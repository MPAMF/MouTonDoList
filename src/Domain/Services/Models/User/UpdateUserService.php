<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\UpdateUserRequest;

interface UpdateUserService
{

    /**
     * @param UpdateUserRequest $request
     * @return User
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws NoPermissionException
     * @throws UserNotFoundException
     */
    public function update(UpdateUserRequest $request): User;
}
