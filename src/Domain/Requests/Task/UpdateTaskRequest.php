<?php

namespace App\Domain\Requests\Task;

class UpdateTaskRequest
{

    private int $userId;
    private int $taskId;
    private array $formData;

    /**
     * @param int $userId
     * @param int $taskId
     * @param array $formData
     */
    public function __construct(int $userId, int $taskId, array $formData)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
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
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }


}