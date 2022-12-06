<?php

namespace App\Domain\Services\Task;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\DeleteTaskRequest;

interface DeleteTaskService
{

    /**
     * @param DeleteTaskRequest $request
     * @return bool
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     * @throws TaskNotFoundException
     */
    public function delete(DeleteTaskRequest $request): bool;

}