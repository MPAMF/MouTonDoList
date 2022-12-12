<?php

namespace App\Domain\Services\Task;

use App\Domain\Requests\Task\DeleteTaskRequest;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Infrastructure\Repositories\TaskRepository;
use DI\Annotation\Inject;

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

        return $this->taskRepository->delete($task) != 0;
    }
}
