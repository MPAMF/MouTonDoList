<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;

interface UpdateInvitationService
{

    /**
     * @param UpdateInvitationRequest $request
     * @return UserCategory
     */
    public function update(UpdateInvitationRequest $request): UserCategory;

}