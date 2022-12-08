<?php

namespace App\Domain\Requests\TaskComment;

class GetTaskCommentRequest
{

    private int $userId;
    private int $taskCommentId;
    private bool $canEdit;
    private ?array $with;

    /**
     * @param int $userId
     * @param int $taskCommentId
     * @param bool $canEdit
     * @param array|null $with
     */
    public function __construct(int $userId, int $taskCommentId, bool $canEdit = true, ?array $with = null)
    {
        $this->userId = $userId;
        $this->taskCommentId = $taskCommentId;
        $this->canEdit = $canEdit;
        $this->with = $with;
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
    public function getTaskCommentId(): int
    {
        return $this->taskCommentId;
    }

    /**
     * @return bool
     */
    public function isCanEdit(): bool
    {
        return $this->canEdit;
    }

    /**
     * @return array|null
     */
    public function getWith(): ?array
    {
        return $this->with;
    }
}
