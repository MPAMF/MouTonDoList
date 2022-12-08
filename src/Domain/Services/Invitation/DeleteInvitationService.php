<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Requests\Task\DeleteTaskRequest;

interface DeleteInvitationService
{
    public function delete(DeleteInvitationRequest $request): bool;
}
