<?php

namespace App\Domain\Requests\User;

class UpdateUserRequest
{
    private int $userId;
    private int $sessionUserId;
    private array $formData;
    private ?string $method;

    /**
     * @param int $userId
     * @param int $sessionUserId
     * @param array $formData
     * @param string|null $method
     */
    public function __construct(int $userId, int $sessionUserId, array $formData, ?string $method = null)
    {
        $this->userId = $userId;
        $this->sessionUserId = $sessionUserId;
        $this->method = $method;
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
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

}
