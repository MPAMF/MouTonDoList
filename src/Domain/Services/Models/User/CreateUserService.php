<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\CreateUserRequest;

interface CreateUserService
{

    /**
     * @param CreateUserRequest $request
     * @return User
     * @throws AlreadyExistsException
     * @throws RepositorySaveException
     * @throws ValidationException
     */
    public function create(CreateUserRequest $request): User;
}
