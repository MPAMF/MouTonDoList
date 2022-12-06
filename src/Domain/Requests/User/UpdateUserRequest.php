<?php

namespace App\Domain\Requests\User;

class UpdateUserRequest
{

    private int $userId;
    private int $categoryId;
    private array $formData;

    /**
     * @param int $userId
     * @param int $categoryId
     * @param array $formData
     */
    public function __construct(int $userId, int $categoryId, array $formData)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
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
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }
}
