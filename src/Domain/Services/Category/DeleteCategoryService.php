<?php

namespace App\Domain\Services\Category;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\DeleteCategoryRequest;

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
