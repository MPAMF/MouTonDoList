<?php

namespace App\Infrastructure\Security;

use App\Domain\Auth\AuthInterface;
use App\Domain\Settings\SettingsInterface;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Lib\Session;

class Auth implements AuthInterface
{
    private UserRepository $userRepository;
    private string $authId;

    public function __construct(UserRepository $userRepository, SettingsInterface $settings)
    {
        $this->userRepository = $userRepository;
        $this->authId = $settings->getOrDefault('auth_session_key', 'user_id');
    }

    /**
     * @return bool User session exists
     */
    public function check(): bool
    {
        return Session::exists($this->authId);
    }

    /**
     * @throws UserNotFoundException
     * @return User object of current session
     */
    public function user(): User
    {
        return $this->userRepository->get(Session::get($this->authId));
    }

    /**
     * @param mixed $user User Id or User object
     */
    public function setUser(int|User $user) : void
    {
        $id = $user instanceof User ? $user->getId() : $user;
        Session::set($this->authId, $id);
    }
}
