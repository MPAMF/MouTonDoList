<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateTaskCommentAction extends Action
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        // TODO:

        return $this->respondWithData(null);
    }
}