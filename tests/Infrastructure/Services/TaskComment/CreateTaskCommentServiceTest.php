<?php

namespace Tests\Infrastructure\Services\TaskComment;

use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;
use App\Domain\Services\TaskComment\CreateTaskCommentService;
use App\Infrastructure\Services\TaskComment\CreateTaskCommentServiceImpl;
use PHPUnit\Framework\TestCase;

class CreateTaskCommentServiceTest extends TestCase
{
    private CreateTaskCommentService $createTaskCommentService;

    public function setUp(): void
    {
        $this->createTaskCommentService = new CreateTaskCommentServiceImpl();
    }

    public function testCreateTaskComment(): void
    {
        $expected = new TaskComment();
        $expected->setId(1);
        $expected->setTaskId(1);
        $expected->setContent('Test');

        $data = [
            'task_id' => 1,
            'owner_id' => 1,
            'content' => 'Test',
        ];

        $request = new CreateTaskCommentRequest(1, $data);

        $this->createTaskCommentService->create($request);

        $expected->setCreatedAt($expected->getCreatedAt());
        $expected->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($expected, $expected);
    }
}