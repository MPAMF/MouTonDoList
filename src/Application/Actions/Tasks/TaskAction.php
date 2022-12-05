<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Repositories\CategoryRepository;
use App\Domain\Repositories\TaskRepository;
use App\Domain\Repositories\UserCategoryRepository;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

abstract class TaskAction extends Action
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
     * @param bool $checkCanEdit
     * @param array|null $with
     * @return Task
     */
    protected function getTaskWithPermissionCheck(bool $checkCanEdit = true, array|null $with = null): Task
    {
        $taskId = (int)$this->resolveArg('id');

        if (!isset($with)) {
            $with = ['category'];
        } else if (!array_key_exists('category', $with)) {
            $with[] = 'category';
        }

        try {
            $task = $this->taskRepository->get($taskId, $with);
        } catch (TaskNotFoundException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }

        if ($task->getCategory() == null) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('CategoryNotFoundException'));
        }

        $categoryId = $task->getCategory()->getParentCategoryId();

        if ($categoryId == null) {
            throw new HttpBadRequestException($this->request, $this->translator->trans('TaskNotFoundException'));
        }

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

        return $task;
    }
}
