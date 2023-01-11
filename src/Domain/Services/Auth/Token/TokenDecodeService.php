<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;

interface TokenDecodeService
{

    /**
     * @param string $token
     * @return User
     * @throws NoPermissionException
     * @throws UserNotFoundException
     */
    public function decode(string $token): User;

}