<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

abstract class TaskCommentAction extends Action
{

    /**
     * @Inject TaskRepository
     */
    protected TaskRepository $taskRepository;

    /**
     * @Inject CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    protected UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var TaskCommentRepository
     */
    protected TaskCommentRepository $taskCommentRepository;


    /**
     * @param bool $checkCanEdit
     * @param array|null $with
     * @return TaskComment
     */
    protected function getTaskCommentWithPermissionCheck(bool $checkCanEdit = true, array|null $with = null): TaskComment
    {
        $taskCommentId = (int)$this->resolveArg('id');

        if (!isset($with)) {
            $with = ['category', 'task'];
        } else if (!array_key_exists('category', $with)) {
            $with[] = 'category';
        } else if (!array_key_exists('task', $with)) {
            $with[] = 'task';
        }

        try {
            $taskComment = $this->taskCommentRepository->get($taskCommentId, $with);
        } catch (TaskCommentNotFoundException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }

        if ($taskComment->getTask() == null || $taskComment->getTask()->getCategory() == null) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('TaskNotFoundException'));
        }

        $categoryId = $taskComment->getTask()->getCategory()->getParentCategoryId();

        if ($checkCanEdit) {
            if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId,
                userId: $this->user()->getId(), accepted: true, canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }
        } else {
            if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId,
                userId: $this->user()->getId(), accepted: true)) {
                throw new HttpForbiddenException($this->request);
            }
        }

        return $taskComment;
    }
}
