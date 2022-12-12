<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Requests\Invitation\ListInvitationRequest;

interface ListInvitationService
{
    /**
     * @param ListInvitationRequest $request
     * @return array
     */
    public function list(ListInvitationRequest $request): array;
}
