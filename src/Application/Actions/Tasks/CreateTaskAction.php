<?php

namespace App\Application\Actions\Tasks;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\Task;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class CreateTaskAction extends TaskAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->validate();
        $userId = $this->user()->getId();
        //
        $task = new Task();
        $task->setCategoryId($data->category_id);
        $task->setName($data->name);
        $task->setDescription($data->description);
        $task->setDueDate($data->due_date);
        $task->setChecked($data->checked);
        $task->setPosition($data->position);
        $task->setLastEditorId($data->last_editor_id ?? null);
        $task->setAssignedId($data->parent_category_id ?? null);
        $task->setLastEditorId($userId);

        // Check category validity
        try {
            $task->setCategory($this->categoryRepository->get($task->getId()));
        } catch (CategoryNotFoundException) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('CategoryNotFoundException'));
        }

        // Only accept to create tasks in subcategories
        if ($task->getCategory()->getParentCategoryId() == null) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('CategoryParentException'));
        }

        // Check can edit
        if ($task->getCategory()->getOwnerId() != $userId) {
            if (!$this->userCategoryRepository->exists(null, $task->getCategoryId(), $userId, accepted: true, canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }
        }

        // Check assigned_id
        if ($task->getAssignedId() != null) {

            // Check if assigned user has access to the project
            if (!$this->userCategoryRepository->exists(null, $task->getCategoryId(), $task->getAssignedId(), accepted: true)) {
                throw new HttpBadRequestException($this->request, $this->translator->trans('AssignedUserNotFoundException'));
            }

        }

        if (!$this->taskRepository->save($task)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskCreateDBError')], 500);
        }

        return $this->respondWithData($task);
    }
}