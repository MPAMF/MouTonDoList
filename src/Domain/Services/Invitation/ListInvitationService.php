<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Requests\Invitation\ListInvitationRequest;

interface ListInvitationService
{

    /**
     * @param ListInvitationRequest $request
     * @return array
     */
    public function list(ListInvitationRequest $request): array;

}