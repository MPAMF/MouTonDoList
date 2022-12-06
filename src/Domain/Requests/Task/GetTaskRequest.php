<?php

namespace App\Domain\Requests\Task;

class GetTaskRequest
{
    private int $userId;
    private int $taskId;
    private bool $canEdit;
    private ?array $with;

    /**
     * @param int $userId
     * @param int $taskId
     * @param bool $canEdit
     * @param array|null $with
     */
    public function __construct(int $userId, int $taskId, bool $canEdit = true, array|null $with = null)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
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
    public function getTaskId(): int
    {
        return $this->taskId;
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