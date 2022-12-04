<?php

namespace App\Application\Actions\TaskComments;

use App\Domain\Task\TaskNotFoundException;
use App\Domain\TaskComment\TaskComment;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class CreateTaskCommentAction extends TaskCommentAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $taskComment = new TaskComment();

        $validator = $this->validator->validate($data, $taskComment->getValidatorRules());

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        $data = $validator->getValues();
        $userId = $this->user()->getId();
        //
        $taskComment->fromValidator($data);
        $taskComment->setAuthorId($userId);

        // Check category validity
        try {
            $taskComment->setTask($this->taskRepository->get($taskComment->getTaskId(), with: ['category']));
        } catch (TaskNotFoundException) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('TaskNotFoundException'));
        }

        // Check can edit
        if ($taskComment->getTask()->getCategory()->getOwnerId() != $userId) {
            if (!$this->userCategoryRepository->exists(null, $taskComment->getTask()->getCategoryId(), $userId, accepted: true, canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }
        }

        if (!$this->taskCommentRepository->save($taskComment)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskCommentCreateDBError')], 500);
        }

        return $this->respondWithData($taskComment);
    }
}