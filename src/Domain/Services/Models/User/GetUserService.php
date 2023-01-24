<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\GetUserRequest;

interface GetUserService
{

    /**
     * @param GetUserRequest $request
     * @return User
     * @throws NoPermissionException
     * @throws UserNotFoundException
     */
    public function get(GetUserRequest $request): User;
}
