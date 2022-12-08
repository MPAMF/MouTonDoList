<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Requests\Task\GetTaskRequest;

interface GetInvitationService
{
    /**
     * @param GetInvitationRequest $request
     * @return UserCategory
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     * @throws UserCategoryNotFoundException
     */
    public function get(GetInvitationRequest $request): UserCategory;
}
