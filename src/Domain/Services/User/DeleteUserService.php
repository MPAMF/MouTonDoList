<?php

namespace App\Domain\Services\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\User\DeleteUserRequest;

interface DeleteUserService
{

    /**
     * @param DeleteUserRequest $request
     * @return bool Deleted
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     */
    public function delete(DeleteUserRequest $request): bool;
}
