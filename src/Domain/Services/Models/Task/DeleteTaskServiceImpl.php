<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Requests\Task\DeleteTaskRequest;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Infrastructure\Repositories\TaskRepository;

class DeleteTaskServiceImpl implements DeleteTaskService
{
    /**
     * @Inject
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * @Inject
     * @var GetTaskService
     */
    public GetTaskService $getTaskService;

    /**
     * {@inheritDoc}
     */
    public function delete(DeleteTaskRequest $request): bool
    {
        $task = $this->getTaskService->get(new GetTaskRequest(
            userId: $request->getUserId(),
            taskId: $request->getTaskId(),
            canEdit: true
        ));

        if ($this->taskRepository->delete($task) == 0) return false;

        // reorder positions
        return $this->taskRepository->orderTasks($task, 0, 0, true);
    }
}
