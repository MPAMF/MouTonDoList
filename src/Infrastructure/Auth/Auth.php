<?php

namespace App\Infrastructure\Auth;

use App\Application\Settings\Settings;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Lib\Session;

class Auth
{
    private UserRepository $userRepository;
    private string $authId;

    public function __construct(UserRepository $userRepository, Settings $settings)
    {
        $this->userRepository = $userRepository;
        $this->authId = $settings->getOrDefault('APP_AUTH_ID', 'user_id');
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
}
