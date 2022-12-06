<?php

namespace App\Domain\Requests\TaskComment;

class UpdateTaskCommentRequest
{

    private int $userId;
    private int $taskCommentId;
    private array $formData;

    /**
     * @param int $userId
     * @param int $taskCommentId
     * @param array $formData
     */
    public function __construct(int $userId, int $taskCommentId, array $formData)
    {
        $this->userId = $userId;
        $this->taskCommentId = $taskCommentId;
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
    public function getTaskCommentId(): int
    {
        return $this->taskCommentId;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }


}