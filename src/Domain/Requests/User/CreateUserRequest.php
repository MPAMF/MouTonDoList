<?php

namespace App\Domain\Requests\User;

class CreateUserRequest
{

    private int $userId;
    private array $formData;

    /**
     * @param int $userId
     * @param array $formData
     */
    public function __construct(int $userId, array $formData)
    {
        $this->userId = $userId;
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
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }
}
