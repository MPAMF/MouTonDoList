<?php

namespace App\Domain\Services\Task;

use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use DI\Annotation\Inject;

class GetTaskServiceImpl implements GetTaskService
{

    /**
     * @Inject
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * @Inject
     * @var UserCategoryCheckPermissionService
     */
    public UserCategoryCheckPermissionService $categoryCheckPermissionService;

    /**
     * {@inheritDoc}
     */
    public function get(GetTaskRequest $request): Task
    {
        $taskId = $request->getTaskId();
        $with = $request->getWith();
        $userId = $request->getUserId();

        if (!isset($with)) {
            $with = ['category'];
        } elseif (!array_key_exists('category', $with)) {
            $with[] = 'category';
        }

        $task = $this->taskRepository->get($taskId, $with);

        if ($task->getCategory() == null) {
            throw new CategoryNotFoundException();
        }

        // Permissions only on parent category (UserCategory)
        $categoryId = $task->getCategory()->getParentCategoryId();

        if ($categoryId == null) {
            throw new CategoryNotFoundException();
        }

        // Throws NoPermissionException
        $this->categoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
            userId: $userId,
            categoryId: $categoryId,
            canEdit: $request->isCanEdit()
        ));

        return $task;
    }
}
