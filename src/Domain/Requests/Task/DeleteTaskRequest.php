<?php

namespace App\Domain\Requests\Task;

class DeleteTaskRequest
{

    private int $userId;
    private int $taskId;

    /**
     * @param int $userId
     * @param int $taskId
     */
    public function __construct(int $userId, int $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
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
}
