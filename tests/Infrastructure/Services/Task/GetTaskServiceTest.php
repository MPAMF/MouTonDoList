<?php

namespace Tests\Infrastructure\Services\Task;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Services\Models\Task\GetTaskService;
use App\Domain\Services\Models\Task\GetTaskServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\TaskRepository;
use PHPUnit\Framework\TestCase;

class GetTaskServiceTest extends TestCase
{
    private TaskRepository $taskRepository;
    private CategoryRepository $categoryRepository;
    private GetTaskService $getTaskService;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->getTaskService = new GetTaskServiceImpl();
        $this->getTaskService->taskRepository = $this->taskRepository;
        $this->getTaskService->categoryRepository = $this->categoryRepository;
    }

    public function testGetTask(): void
    {
        $expected = new Task();
        $expected->setId(1);
        $expected->setCategoryId(1);
        $expected->setName('Test');
        $expected->setDescription('Test');
        $expected->setDueDate(new \DateTime());
        $expected->setPosition(0);

        $this->taskRepository->method('find')->willReturn($expected);

        $category = new Category();
        $category->setOwnerId(1);
        $this->categoryRepository->method('find')->willReturn($category);

        $request = new GetTaskRequest(1, 1, 1);
        $task = $this->getTaskService->get($request);

        $expected->setCreatedAt($task->getCreatedAt());
        $expected->setUpdatedAt($task->getUpdatedAt());

        $this->assertEquals($task, $expected);
    }
}