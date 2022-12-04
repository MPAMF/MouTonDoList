<?php

namespace App\Application\Actions\TaskComments;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteTaskCommentAction extends TaskCommentAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $task = $this->getTaskCommentWithPermissionCheck();
        // Useless to check if something was deleted
        $this->taskCommentRepository->delete($task);

        return $this->respondWithData(null, 204);
    }
}