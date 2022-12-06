<?php

namespace App\Infrastructure\Services\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\TaskComment\GetTaskCommentService;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use App\Infrastructure\Services\Service;

class GetTaskCommentServiceImpl extends Service implements GetTaskCommentService
{

    /**
     * @Inject
     * @var TaskCommentRepository
     */
    public TaskCommentRepository $taskCommentRepository;

    /**
     * @Inject
     * @var UserCategoryCheckPermissionService
     */
    public UserCategoryCheckPermissionService $categoryCheckPermissionService;

    /**
     * {@inheritDoc}
     */
    public function get(GetTaskCommentRequest $request): TaskComment
    {
        $taskCommentId = $request->getTaskCommentId();
        $with = $request->getWith();
        $userId = $request->getUserId();

        if (!isset($with)) {
            $with = ['category', 'task'];
        } else {
            if (!array_key_exists('category', $with)) {
                $with[] = 'category';
            }
            if (!array_key_exists('task', $with)) {
                $with[] = 'task';
            }
        }

        $taskComment = $this->taskCommentRepository->get($taskCommentId, $with);

        if ($taskComment->getTask() == null || $taskComment->getTask()->getCategory() == null) {
            throw new BadRequestException($this->translator->trans('TaskNotFoundException'));
        }

        $categoryId = $taskComment->getTask()->getCategory()->getParentCategoryId();

        $this->categoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
            userId: $userId,
            categoryId: $categoryId,
            canEdit: $request->isCanEdit()
        ));

        return $taskComment;
    }
}
