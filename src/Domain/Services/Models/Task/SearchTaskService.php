<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Requests\Task\SearchTaskRequest;

interface SearchTaskService
{

    /**
     * @param SearchTaskRequest $request
     * @return array
     */
    public function search(SearchTaskRequest $request): array;
}
