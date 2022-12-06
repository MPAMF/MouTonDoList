<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Services\Invitation\CreateInvitationService;
use App\Domain\Services\Invitation\ListInvitationsService;
use Psr\Http\Message\ResponseInterface as Response;

class CreateInvitationAction extends Action
{

    /**
     * @Inject
     * @var CreateInvitationService
     */
    private CreateInvitationService $createInvitationService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
        return $this->respondWithData();
    }

}
