<?php

namespace App\Domain\Services\User;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\CreateUserRequest;

interface CreateUserService
{

    /**
     * @param CreateUserRequest $request
     * @return User
     * @throws RepositorySaveException
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws ValidationException
     */
    public function create(CreateUserRequest $request): User;
}
