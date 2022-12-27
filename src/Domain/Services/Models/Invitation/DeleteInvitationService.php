<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;

interface DeleteInvitationService
{
    /**
     * @param DeleteInvitationRequest $request
     * @return bool
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     * @throws UserCategoryNotFoundException
     */
    public function delete(DeleteInvitationRequest $request): bool;
}
