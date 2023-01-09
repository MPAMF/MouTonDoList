<?php

namespace Tests\Infrastructure\Services\Task;

use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Services\Task\CreateTaskService;
use App\Infrastructure\Services\Task\CreateTaskServiceImpl;
use App\Domain\Models\Task\TaskRepository;
use Tests\TestCase;

class CreateTaskServiceTest extends TestCase
{
    private TaskRepository $taskRepository;
    private CreateTaskService $createTaskService;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->createTaskService = new CreateTaskServiceImpl(validator: new Validator());
        $this->createTaskService->taskRepository = $this->taskRepository;
    }

    public function testCreateTask(): void
    {
        $expected = new Task();
        $expected->setId(1);
        $expected->setName('Test');
        $expected->setDescription('TestDesc');
        $expected->setCategoryId(1);
        $expected->setPosition(0);

        $data = [
            'owner_id' => 1,
            'category_id' => 1,
            'name' => 'Test',
            'description' => 'TestDesc',
            'position' => 0,
        ];

        $request = new CreateTaskRequest(1, $data);

        $this->taskRepository->expects($this->once())->method('save')->with(self::callback(function (Task $t) {$t->setId(1);
        return true;
    }))->willReturn(true);

    $createdTask = $this->createTaskService->create($request);

    $createdTask->setCreatedAt($expected->getCreatedAt());
    $createdTask->setUpdatedAt($expected->getUpdatedAt());

    $this->assertEquals($createdTask, $expected);
    }
}