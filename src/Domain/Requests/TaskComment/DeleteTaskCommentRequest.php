<?php

namespace App\Domain\Requests\TaskComment;

class DeleteTaskCommentRequest
{

    private int $userId;
    private int $taskCommentId;

    /**
     * @param int $userId
     * @param int $taskCommentId
     */
    public function __construct(int $userId, int $taskCommentId)
    {
        $this->userId = $userId;
        $this->taskCommentId = $taskCommentId;
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

}