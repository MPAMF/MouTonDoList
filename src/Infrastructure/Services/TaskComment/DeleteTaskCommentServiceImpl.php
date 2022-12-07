<?php

namespace App\Infrastructure\Services\TaskComment;

use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Services\TaskComment\DeleteTaskCommentService;
use App\Domain\Services\TaskComment\GetTaskCommentService;

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
