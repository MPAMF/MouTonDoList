<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Requests\User\DeleteUserRequest;

class DeleteUserServiceImpl implements DeleteUserService
{

    /**
     * @inheritDoc
     */
    public function delete(DeleteUserRequest $request): bool
    {
        // TODO: Implement delete() method.
        return false;
    }
}