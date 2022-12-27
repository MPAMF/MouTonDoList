<?php

namespace App\Domain\Requests\User;

class DeleteUserRequest
{

    private int $userId;
    private int $sessionUserId;

    /**
     * @param int $userId
     * @param int $sessionUserId
     */
    public function __construct(int $userId, int $sessionUserId)
    {
        $this->userId = $userId;
        $this->sessionUserId = $sessionUserId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getSessionUserId(): int
    {
        return $this->sessionUserId;
    }
}
