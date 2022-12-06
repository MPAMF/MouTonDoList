<?php

namespace App\Domain\Requests\Category;

class GetCategoryRequest
{

    private int $userId;
    private int $categoryId;
    private bool $canEdit;

    /**
     * @param int $userId
     * @param int $categoryId
     * @param bool $canEdit
     */
    public function __construct(int $userId, int $categoryId, bool $canEdit = true)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
        $this->canEdit = $canEdit;
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
     * @return bool
     */
    public function isCanEdit(): bool
    {
        return $this->canEdit;
    }
}
