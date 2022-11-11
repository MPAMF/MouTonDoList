<?php

namespace App\Domain\Auth;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;

interface AuthInterface
{

    /**
     * @return bool User session exists
     */
    public function check(): bool;

    /**
     * @throws UserNotFoundException
     * @return User object of current session
     */
    public function user(): User;

}