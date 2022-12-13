<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;

interface TokenLoginService
{


    /**
     * @param LoginRequest $request
     * @return string Token
     * @throws BadRequestException
     * @throws UserNotFoundException
     */
    public function login(LoginRequest $request) : string;

}