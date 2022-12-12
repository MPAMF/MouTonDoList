<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Models\User\User;
use App\Domain\Requests\User\CreateUserRequest;

class CreateUserServiceImpl implements CreateUserService
{

    /**
     * @inheritDoc
     */
    public function create(CreateUserRequest $request): User
    {
        // TODO: Implement create() method.
        return new User();
    }
}