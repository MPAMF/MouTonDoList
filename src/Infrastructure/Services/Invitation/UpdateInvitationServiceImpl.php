<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Services\Invitation\UpdateInvitationService;

class UpdateInvitationServiceImpl implements UpdateInvitationService
{

    public function update(UpdateInvitationRequest $request): UserCategory
    {
        // TODO: Implement answer() method.
        return new UserCategory();
    }
}
