<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;

interface TokenGenService
{


    /**
     * @param LoginRequest $request
     * @return string Token
     * @throws BadRequestException
     * @throws UserNotFoundException
     */
    public function generate(LoginRequest $request) : string;

}