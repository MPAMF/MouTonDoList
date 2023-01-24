<?php

namespace Tests\Infrastructure\Services\Task;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Services\Models\Task\CreateTaskService;
use App\Domain\Services\Models\Task\CreateTaskServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Tagliatti\SlimValidation\Validator;
use Symfony\Component\Translation\Translator;
use Tests\TestCase;

class CreateTaskServiceTest extends TestCase
{
    private TaskRepository $taskRepository;
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private CreateTaskService $createTaskService;
    private Translator $translator;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(Translator::class);
        $this->createTaskService = new CreateTaskServiceImpl(new Validator(), $this->translator);
        $this->createTaskService->taskRepository = $this->taskRepository;
        $this->createTaskService->categoryRepository = $this->categoryRepository;
        $this->createTaskService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testCreateTask(): void
    {
        $this->categoryRepository->expects($this->once())
            ->method('get')
            ->willReturn(new Category());

        $this->userCategoryRepository->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->taskRepository->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $expected = new Task();
        $expected->setId(1);
        $expected->setName('Test task');
        $expected->setDescription('Test description');
        $expected->setChecked(false);
        $expected->setPosition(0);
        $expected->setCategoryId(1);
        $expected->setLastEditorId(1);
        $expected->setAssignedId(1);

        $data = [
            'name' => 'Test task',
            'description' => 'Test description',
            'checked' => false,
            'position' => 0,
            'category_id' => 1,
            'last_editor_id' => 1,
            'assigned_id' => 1,
        ];

        $request = new CreateTaskRequest(1,$data);

        $this->taskRepository->expects($this->once())
            ->method('save')->with(self::callback(function (Task $c) {
                $c->setId(1);
                return true;
            }))->willReturn(true);

        $createdTask = $this->createTaskService->create($request);

        // Ignore dates
        $createdTask->setCreatedAt($expected->getCreatedAt());
        $createdTask->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($createdTask, $expected);
    }
}
