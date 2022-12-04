<?php

namespace App\Application\Actions\TaskComments;

use Psr\Http\Message\ResponseInterface as Response;

class ViewTaskCommentAction extends TaskCommentAction
{

    protected function action(): Response
    {
        $taskComment = $this->getTaskCommentWithPermissionCheck(checkCanEdit: false);
        return $this->respondWithData($taskComment);
    }
}