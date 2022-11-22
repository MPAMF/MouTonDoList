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
     * @return User object of current session
     * @throws UserNotFoundException
     */
    public function user(): User;


    /**
     * @param int|User $user User Id or User object
     * @return void
     */
    public function setUser(int|User $user): void;

    /**
     * @return void
     */
    public function removeUser() : void;

}