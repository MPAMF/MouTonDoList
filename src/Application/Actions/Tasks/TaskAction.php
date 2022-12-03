<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DateTime;
use Respect\Validation\Rules\Date;
use Respect\Validation\Validator;
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

        try {
            $task = $this->taskRepository->get($taskId, $with);
        } catch (TaskNotFoundException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }

        if ($checkCanEdit) {
            if (!$this->userCategoryRepository->exists(null, categoryId: $task->getCategoryId(),
                userId: $this->user()->getId(), accepted: true, canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }
        } else {
            if (!$this->userCategoryRepository->exists(null, categoryId: $task->getCategoryId(),
                userId: $this->user()->getId(), accepted: true)) {
                throw new HttpForbiddenException($this->request);
            }
        }

        return $task;
    }
}
