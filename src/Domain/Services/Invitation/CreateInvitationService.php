<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;

interface CreateInvitationService
{

    /**
     * @param CreateInvitationRequest $request
     * @return UserCategory
     */
    public function create(CreateInvitationRequest $request) : UserCategory;

}