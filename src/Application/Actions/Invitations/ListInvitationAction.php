<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Requests\Invitation\ListInvitationRequest;
use App\Domain\Services\Models\Invitation\ListInvitationService;
use Psr\Http\Message\ResponseInterface as Response;

class ListInvitationAction extends Action
{

    /**
     * @Inject
     * @var ListInvitationService
     */
    private ListInvitationService $listInvitationsService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        $data = $this->listInvitationsService->list(new ListInvitationRequest(
            userId: $this->user()->getId()
        ));

        return $this->respondWithData($data);
    }
}