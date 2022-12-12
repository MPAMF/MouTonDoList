<?php

namespace App\Domain\Services\Models\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;

interface GetTaskCommentService
{

    /**
     * @param GetTaskCommentRequest $request
     * @return TaskComment
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws TaskCommentNotFoundException
     */
    public function get(GetTaskCommentRequest $request): TaskComment;
}
