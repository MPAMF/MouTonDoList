<?php

namespace App\Infrastructure\Services\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Requests\Task\DeleteTaskRequest;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Services\Task\DeleteTaskService;
use App\Domain\Services\Task\GetTaskService;
use App\Domain\Services\TaskComment\DeleteTaskCommentService;
use App\Domain\Services\TaskComment\GetTaskCommentService;
use DI\Annotation\Inject;

class DeleteTaskCommentServiceImpl implements DeleteTaskCommentService
{
    /**
     * @Inject
     * @var TaskCommentRepository
     */
    public TaskCommentRepository $taskCommentRepository;

    /**
     * @Inject
     * @var GetTaskCommentService
     */
    public GetTaskCommentService $getTaskCommentService;

    /**
     * {@inheritDoc}
     */
    public function delete(DeleteTaskCommentRequest $request): bool
    {
        $taskComment = $this->getTaskCommentService->get(new GetTaskCommentRequest(
            userId: $request->getUserId(),
            taskCommentId: $request->getTaskCommentId(),
            canEdit: true
        ));

        return $this->taskCommentRepository->delete($taskComment) != 0;
    }
}