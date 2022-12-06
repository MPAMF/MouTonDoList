<?php

namespace App\Domain\Models\Category\Services;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\Requests\DeleteCategoryRequest;

interface DeleteCategoryService
{

    /**
     * @param DeleteCategoryRequest $request
     * @return bool Deleted
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     */
    public function delete(DeleteCategoryRequest $request): bool;

}