<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\DeleteUserRequest;

interface DeleteUserService
{

    /**
     * @param DeleteUserRequest $request
     * @return bool
     * @throws NoPermissionException
     * @throws UserNotFoundException
     */
    public function delete(DeleteUserRequest $request): bool;

}
