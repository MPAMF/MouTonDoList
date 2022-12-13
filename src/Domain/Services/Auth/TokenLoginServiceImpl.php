<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;
use DI\Annotation\Inject;

class TokenLoginServiceImpl implements TokenLoginService
{

    /**
     * @Inject
     * @var LoginService
     */
    private LoginService $loginService;

    /**
     * @inheritDoc
     */
    public function login(LoginRequest $request): string
    {
        $user = $this->loginService->login($request);
        return base64_encode($user->getEmail());
    }
}