<?php

namespace App\Domain\Services\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;

interface DeleteTaskCommentService
{

    /**
     * @param DeleteTaskCommentRequest $request
     * @return bool
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws TaskCommentNotFoundException
     */
    public function delete(DeleteTaskCommentRequest $request): bool;
}
