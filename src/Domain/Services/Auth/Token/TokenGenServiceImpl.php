<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Requests\Auth\LoginRequest;
use App\Domain\Services\Auth\LoginService;
use DI\Annotation\Inject;

class TokenGenServiceImpl implements TokenGenService
{

    /**
     * @Inject
     * @var LoginService
     */
    private LoginService $loginService;

    /**
     * @inheritDoc
     */
    public function generate(LoginRequest $request): string
    {
        $user = $this->loginService->login($request);
        return base64_encode($user->getEmail());
    }
}