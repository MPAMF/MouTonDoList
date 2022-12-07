<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Requests\Invitation\ListInvitationsRequest;
use App\Domain\Services\Invitation\ListInvitationsService;
use Psr\Http\Message\ResponseInterface as Response;

class ListInvitationsAction extends Action
{

    /**
     * @Inject
     * @var ListInvitationsService
     */
    private ListInvitationsService $listInvitationsService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        $data = $this->listInvitationsService->list(new ListInvitationsRequest(
            userId: $this->user()->getId()
        ));

        return $this->respondWithData($data);
    }
}