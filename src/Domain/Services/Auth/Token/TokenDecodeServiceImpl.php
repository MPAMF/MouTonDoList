<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\User;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;

class TokenDecodeServiceImpl implements TokenDecodeService
{

    /**
     * @Inject()
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @inheritDoc
     */
    public function decode(string $token): User
    {

        $token = base64_decode($token);

        if (!$token) {
            throw new NoPermissionException();
        }

        // No hash on token

        $userId = intval($token);

        if($userId == 0)
        {
            throw new NoPermissionException();
        }

        return $this->userRepository->get($userId);
    }
}