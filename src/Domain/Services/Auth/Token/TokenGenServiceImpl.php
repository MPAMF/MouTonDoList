<?php

namespace App\Domain\Services\Auth\Token;

use App\Domain\Models\User\User;

class TokenGenServiceImpl implements TokenGenService
{

    /**
     * @inheritDoc
     */
    public function generate(User $user): string
    {
        // Hash here
        return base64_encode($user->getId());
    }
}