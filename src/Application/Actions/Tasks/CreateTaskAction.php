<?php

namespace App\Application\Actions\Tasks;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\Task;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;

class CreateTaskAction extends TaskAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->validate();
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

        // TODO: Check if category exists & if user has permission

        /* $parent = $task->getParentCategoryId() == null;

        // Parent category isn't none, check if user has permission to create a new subCategory
        if (!$parent && !$this->userCategoryRepository->exists(null, categoryId: $task->getParentCategoryId(),
                userId: $userId, accepted: true, canEdit: true)) {
            throw new HttpForbiddenException($this->request);
        } */

        // Useless to check if something was deleted
        if (!$this->taskRepository->save($task)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskCreateDBError')], 500);
        }

        return $this->respondWithData($task);
    }
}