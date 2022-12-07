<?php

namespace App\Domain\Services\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\UpdateTaskCommentRequest;

interface UpdateTaskCommentService
{

    /**
     * @param UpdateTaskCommentRequest $request
     * @return TaskComment
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws TaskCommentNotFoundException
     */
    public function update(UpdateTaskCommentRequest $request): TaskComment;
}
