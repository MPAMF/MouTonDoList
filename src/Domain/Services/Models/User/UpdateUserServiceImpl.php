<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Models\User\User;
use App\Domain\Requests\User\UpdateUserRequest;

class UpdateUserServiceImpl implements UpdateUserService
{

    /**
     * @inheritDoc
     */
    public function update(UpdateUserRequest $request): User
    {
        // TODO: Implement update() method.
        return new User();
    }
}