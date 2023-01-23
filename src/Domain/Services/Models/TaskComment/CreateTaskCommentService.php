<?php

namespace App\Domain\Services\Models\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;

interface CreateTaskCommentService
{

    /**
     * @param CreateTaskCommentRequest $request
     * @return TaskComment
     * @throws RepositorySaveException
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws ValidationException
     * @throws TaskNotFoundException
     */
    public function create(CreateTaskCommentRequest $request): TaskComment;
}
