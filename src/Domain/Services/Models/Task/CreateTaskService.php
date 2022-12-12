<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\CreateTaskRequest;

interface CreateTaskService
{

    /**
     * @param CreateTaskRequest $request
     * @return Task
     * @throws BadRequestException
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     * @throws RepositorySaveException
     * @throws ValidationException
     */
    public function create(CreateTaskRequest $request): Task;
}
