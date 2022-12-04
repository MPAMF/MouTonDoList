<?php

namespace App\Application\Actions\TaskComments;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateTaskCommentAction extends TaskCommentAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $taskComment = $this->getTaskCommentWithPermissionCheck(with: ['task', 'category']);

        $validator = $this->validator->validate($data, $taskComment->getValidatorRules());

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        $data = $validator->getValues();
        $userId = $this->user()->getId();

        if ($taskComment->getAuthorId() != $userId) {
            throw new HttpForbiddenException($this->request);
        }

        // Disable update of author_id and task_id
        $data->author_id = $taskComment->getAuthorId();
        $data->task_id = $taskComment->getTaskId();
        //
        $taskComment->fromValidator($data);

        // Useless to check if something was deleted
        if (!$this->taskCommentRepository->save($taskComment)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskCommentUpdateDBError')], 500);
        }

        return $this->respondWithData($taskComment);
    }
}