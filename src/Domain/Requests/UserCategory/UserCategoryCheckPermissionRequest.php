<?php

namespace App\Domain\Requests\UserCategory;

class UserCategoryCheckPermissionRequest
{

    private int $userId;
    private int $categoryId;
    private bool $canEdit;
    private bool $checkAccepted;
    private bool $accepted;

    /**
     * @param int $userId
     * @param int $categoryId
     * @param bool $canEdit
     * @param bool $checkAccepted
     * @param bool $accepted
     */
    public function __construct(int $userId, int $categoryId, bool $canEdit = true, bool $checkAccepted = true, bool $accepted = true)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
        $this->canEdit = $canEdit;
        $this->checkAccepted = $checkAccepted;
        $this->accepted = $accepted;
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
    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    /**
     * @return bool
     */
    public function isCheckAccepted(): bool
    {
        return $this->checkAccepted;
    }

    /**
     * @return bool
     */
    public function isCanEdit(): bool
    {
        return $this->canEdit;
    }
}
