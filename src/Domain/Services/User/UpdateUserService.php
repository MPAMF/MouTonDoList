<?php

namespace App\Domain\Services\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\UpdateUserRequest;

interface UpdateUserService
{

    /**
     * @param UpdateUserRequest $request
     * @return User
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     */
    public function update(UpdateUserRequest $request): User;

}