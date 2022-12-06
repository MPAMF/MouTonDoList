<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Requests\Invitation\ListInvitationsRequest;
use App\Domain\Services\Invitation\ListInvitationsService;

class ListInvitationsServiceImpl implements ListInvitationsService
{

    public function list(ListInvitationsRequest $request): array
    {
        // TODO: Implement list() method.
        return [];
    }
}