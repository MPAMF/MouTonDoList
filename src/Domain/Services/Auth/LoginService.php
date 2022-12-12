<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;

interface LoginService
{

    /**
     * @param LoginRequest $request
     * @return User
     * @throws UserNotFoundException
     * @throws BadRequestException
     */
    public function login(LoginRequest $request): User;

}