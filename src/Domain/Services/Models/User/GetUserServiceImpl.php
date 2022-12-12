<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Models\User\User;
use App\Domain\Requests\User\GetUserRequest;

class GetUserServiceImpl implements GetUserService
{

    /**
     * @inheritDoc
     */
    public function get(GetUserRequest $request): User
    {
        return new User();
    }
}