<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Models\User\User;
use App\Domain\Requests\Auth\RegisterUserRequest;

interface RegisterUserService
{

    /**
     * @param RegisterUserRequest $request
     * @return User
     * @throws BadRequestException
     * @throws RepositorySaveException
     */
    public function register(RegisterUserRequest $request): User;

}