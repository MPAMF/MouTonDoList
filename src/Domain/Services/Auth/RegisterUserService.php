<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Models\User\User;
use App\Domain\Requests\Auth\RegisterRequest;

interface RegisterUserService
{

    /**
     * @param RegisterRequest $request
     * @return User
     * @throws BadRequestException
     * @throws RepositorySaveException
     */
    public function register(RegisterRequest $request): User;

}