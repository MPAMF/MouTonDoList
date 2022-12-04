<?php

namespace App\Application\Actions\Tasks;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Task\Task;
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

        $data = $this->getFormData();
        $task = new Task();

        $validator = $this->validator->validate($data, $task->getValidatorRules());

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        $data = $validator->getValues();

        $userId = $this->user()->getId();
        //
        $task->fromValidator($data);
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