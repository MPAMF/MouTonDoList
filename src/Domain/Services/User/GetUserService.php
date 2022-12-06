<?php

namespace App\Domain\Services\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\GetUserRequest;

interface GetUserService
{

    /**
     * @param GetUserRequest $request
     * @return User
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     */
    public function get(GetUserRequest $request) : User;

}