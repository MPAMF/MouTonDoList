<?php

namespace Tests\Infrastructure\Services\TaskComment;

use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Services\Models\TaskComment\GetTaskCommentService;
use App\Infrastructure\Repositories\TaskCommentRepository;
use App\Domain\Services\Models\TaskComment\GetTaskCommentServiceImpl;
use Tests\TestCase;

class GetTaskCommentServiceTest extends TestCase
{
    private TaskCommentRepository $taskCommentRepository;
    private GetTaskCommentService $getTaskCommentService;

    public function setUp(): void
    {
        $this->taskCommentRepository = $this->createMock(TaskCommentRepository::class);
        $this->getTaskCommentService = new GetTaskCommentServiceImpl();
        $this->getTaskCommentService->taskCommentRepository = $this->taskCommentRepository;
    }

    public function testGetTaskComment(): void
    {
        $expected = new TaskComment();
        $expected->setId(1);
        $expected->setTaskId(1);
        $expected->setContent('Test');

        $this->taskCommentRepository->expects($this->once())
            ->method('find')->with(1)->willReturn($expected);

        $request = new GetTaskCommentRequest(1, 1);
        $taskComment = $this->getTaskCommentService->get($request);

        $expected->setCreatedAt($expected->getCreatedAt());
        $expected->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($taskComment, $expected);
    }
}