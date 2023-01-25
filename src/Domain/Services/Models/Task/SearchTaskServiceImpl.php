<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Requests\Task\SearchTaskRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionService;
use App\Infrastructure\Repositories\TaskRepository;

class SearchTaskServiceImpl implements SearchTaskService
{

    /**
     * @Inject
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * {@inheritDoc}
     */
    public function search(SearchTaskRequest $request): array
    {
        $with = $request->getWith();
        $userId = $request->getUserId();
        $searchInput = $request->getSearchInput();

        if(empty($searchInput)) return [];
        return $this->taskRepository->searchTasks($searchInput, $userId, $with);
    }
}
