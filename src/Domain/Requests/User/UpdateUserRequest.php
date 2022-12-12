<?php

namespace App\Domain\Requests\User;

class UpdateUserRequest
{

    private int $userId;
    private int $sessionUserId;
    private array $formData;

    /**
     * @param int $userId
     * @param int $sessionUserId
     * @param array $formData
     */
    public function __construct(int $userId, int $sessionUserId, array $formData)
    {
        $this->userId = $userId;
        $this->sessionUserId = $sessionUserId;
        $this->formData = $formData;
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

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }
}
