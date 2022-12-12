<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\GetInvitationRequest;

interface GetInvitationService
{
    /**
     * @param GetInvitationRequest $request
     * @return UserCategory
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     * @throws UserCategoryNotFoundException
     */
    public function get(GetInvitationRequest $request): UserCategory;
}
