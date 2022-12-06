<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Services\Invitation\AnswerInvitationService;
use Psr\Http\Message\ResponseInterface as Response;

class AnswerInvitationAction extends Action
{

    /**
     * @Inject
     * @var AnswerInvitationService
     */
    private AnswerInvitationService $answerInvitationService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
        return $this->respondWithData();
    }
}
