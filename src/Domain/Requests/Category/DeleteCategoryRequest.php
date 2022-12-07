<?php

namespace App\Domain\Requests\Category;

class DeleteCategoryRequest
{

    private int $userId;
    private int $categoryId;

    /**
     * @param int $userId
     * @param int $categoryId
     */
    public function __construct(int $userId, int $categoryId)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
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
}
