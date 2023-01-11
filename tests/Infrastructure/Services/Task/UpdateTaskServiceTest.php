<?php

namespace Tests\Infrastructure\Services\Task;

use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\UpdateTaskRequest;
use App\Domain\Services\Models\Task\UpdateTaskService;
use App\Domain\Services\Models\Task\UpdateTaskServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\TaskRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class UpdateTaskServiceTest extends TestCase
{
    private TaskRepository $taskRepository;
    private CategoryRepository $categoryRepository;
    private UpdateTaskService $updateTaskService;
    private TranslatorInterface $translator;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->updateTaskService = new UpdateTaskServiceImpl(new Validator(), $this->translator);
        $this->updateTaskService->taskRepository = $this->taskRepository;
        $this->updateTaskService->categoryRepository = $this->categoryRepository;
    }

    public function testUpdateTask(): void
    {
        $this->taskRepository->expects($this->once())
            ->method('save');

        $expected = new Task();
        $expected->setId(1);
        $expected->setCategoryId(1);
        $expected->setName('Test');
        $expected->setDescription('Test description');
        $expected->setDueDate(new \DateTime('2022-01-01'));
        $expected->setPosition(0);

        $data = [
            'name' => 'Test',
            'description' => 'Test description',
            'due_date' => '2022-01-01',
            'completed' => false,
            'position' => 0,
        ];

        $request = new UpdateTaskRequest(1, 1, $data);

        $this->taskRepository->expects($this->once())
            ->method('findOrFail')
            ->willReturn($expected);

        $updatedTask = $this->updateTaskService->update($request);

        $updatedTask->setCreatedAt($expected->getCreatedAt());
        $updatedTask->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($updatedTask, $expected);
    }
}
