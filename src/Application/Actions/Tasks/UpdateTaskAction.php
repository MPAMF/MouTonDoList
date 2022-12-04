<?php

namespace App\Application\Actions\Tasks;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateTaskAction extends TaskAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $task = $this->getTaskWithPermissionCheck(with: ['category']);

        $validator = $this->validator->validate($data, $task->getValidatorRules());

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        $data = $validator->getValues();
        $userId = $this->user()->getId();

        // Check category validity
        if (!isset($data->category_id)) // categoryId == null is main category, cannot create tasks in those categories
        {
            throw new HttpBadRequestException($this->request, $this->translator->trans('CategoryIdNotValid'));
        } else {
            // Check if current category has same parentCategory
            if (!$this->categoryRepository->exists($data->category_id, $task->getCategory()->getParentCategoryId())) {
                throw new HttpForbiddenException($this->request);
            }
        }

        $task->fromValidator($data);
        $task->setLastEditorId($userId);

        // Useless to check if something was deleted
        if (!$this->taskRepository->save($task)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskUpdateDBError')], 500);
        }

        return $this->respondWithData($task);
    }
}