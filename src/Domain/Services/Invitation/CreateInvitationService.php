<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;

interface CreateInvitationService
{
    /**
     * @param CreateInvitationRequest $request
     * @return UserCategory
     * @throws NoPermissionException
     * @throws ValidationException
     * @throws CategoryNotFoundException
     * @throws UserNotFoundException
     * @throws AlreadyExistsException
     * @throws RepositorySaveException
     */
    public function create(CreateInvitationRequest $request) : UserCategory;
}
