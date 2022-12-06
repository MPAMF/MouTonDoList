<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AnswerInvitationAction extends Action
{

    protected function action(): Response
    {
        // TODO: Implement action() method.
        return $this->respondWithData();
    }
}