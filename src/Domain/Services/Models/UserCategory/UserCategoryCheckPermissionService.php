<?php

namespace App\Domain\Services\Models\UserCategory;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;

interface UserCategoryCheckPermissionService
{

    /**
     * @param UserCategoryCheckPermissionRequest $request
     * @return void
     * @throws NoPermissionException
     */
    public function exists(UserCategoryCheckPermissionRequest $request): void;
}
