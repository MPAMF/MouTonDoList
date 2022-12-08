<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;

interface UpdateInvitationService
{
    /**
     * @param UpdateInvitationRequest $request
     * @return UserCategory
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     * @throws UserCategoryNotFoundException
     */
    public function update(UpdateInvitationRequest $request): UserCategory;
}
