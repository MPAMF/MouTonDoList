<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\GetTaskRequest;

interface GetTaskService
{

    /**
     * @param GetTaskRequest $request
     * @return Task
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     * @throws TaskNotFoundException
     */
    public function get(GetTaskRequest $request): Task;
}
