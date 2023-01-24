<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;

interface TokenGenService
{

    /**
     * @param User $user
     * @return string Token
     * @throws BadRequestException
     * @throws UserNotFoundException
     */
    public function generate(User $user): string;

}