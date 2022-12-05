<?php

namespace App\Infrastructure\Security;

use App\Domain\Auth\AuthInterface;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Repositories\UserRepository;
use App\Domain\Settings\SettingsInterface;
use App\Infrastructure\Lib\Session;

class AuthImpl implements AuthInterface
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
     * @return User object of current session
     * @throws UserNotFoundException
     */
    public function user(): User
    {
        return $this->userRepository->get(Session::get($this->authId));
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(int|User $user) : void
    {
        $id = $user instanceof User ? $user->getId() : $user;
        Session::set($this->authId, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function removeUser() : void
    {
        Session::unset($this->authId);
    }
}
