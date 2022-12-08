<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Services\Invitation\UpdateInvitationService;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateInvitationAction extends Action
{

    /**
     * @Inject
     * @var UpdateInvitationService
     */
    private UpdateInvitationService $answerInvitationService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
        return $this->respondWithData();
    }
}
