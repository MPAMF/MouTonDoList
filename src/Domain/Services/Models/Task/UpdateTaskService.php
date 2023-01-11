<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\UpdateTaskRequest;

interface UpdateTaskService
{

    /**
     * @param UpdateTaskRequest $request
     * @return Task
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws CategoryNotFoundException
     * @throws TaskNotFoundException
     */
    public function update(UpdateTaskRequest $request): Task;
}
