<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;
use App\Domain\Services\Invitation\CreateInvitationService;

class CreateInvitationServiceImpl implements CreateInvitationService
{

    public function create(CreateInvitationRequest $request): UserCategory
    {
        // TODO: Implement create() method.
        return new UserCategory();
    }
}