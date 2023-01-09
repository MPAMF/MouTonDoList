<?php

namespace Tests\Infrastructure\Services\Task;

use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\DeleteTaskRequest;
use App\Domain\Services\Task\DeleteTaskService;
use App\Infrastructure\Services\Task\DeleteTaskServiceImpl;
use App\Domain\Models\Task\TaskRepository;
use Tests\TestCase;

class DeleteTaskServiceTest extends TestCase
{
    private TaskRepository $taskRepository;
    private DeleteTaskService $deleteTaskService;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->deleteTaskService = new DeleteTaskServiceImpl();
        $this->deleteTaskService->taskRepository = $this->taskRepository;
    }

    public function testDeleteTask(): void
    {
        $this->taskRepository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(new Task());

        $this->taskRepository->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $request = new DeleteTaskRequest(1, 1);
        $deleted = $this->deleteTaskService->delete($request);

        $this->assertTrue($deleted);
    }
}