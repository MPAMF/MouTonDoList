<?php

namespace Tests\Infrastructure\Services\TaskComment;

use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;
use App\Domain\Services\TaskComment\DeleteTaskCommentService;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Infrastructure\Services\TaskComment\DeleteTaskCommentServiceImpl;
use PHPUnit\Framework\TestCase;

class DeleteTaskCommentServiceTest extends TestCase
{
    private TaskCommentRepository $taskCommentRepository;
    private DeleteTaskCommentService $deleteTaskCommentService;

    public function setUp(): void
    {
        $this->taskCommentRepository = $this->createMock(TaskCommentRepository::class);
        $this->deleteTaskCommentService = new DeleteTaskCommentServiceimpl();
        $this->deleteTaskCommentService->taskCommentRepository = $this->taskCommentRepository;
    }

    public function testDeleteTaskComment(): void
    {
        $request = new DeleteTaskCommentRequest(1, 1);
        $taskComment = new TaskComment();
        $taskComment->setId(1);

        $this->taskCommentRepository->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($taskComment);

        $this->taskCommentRepository->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $this->assertTrue($this->deleteTaskCommentService->delete($request));
    }
}