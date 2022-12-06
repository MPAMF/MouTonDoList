<?php

namespace App\Domain\Models\Category\Services;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\Requests\UpdateCategoryRequest;

interface UpdateCategoryService
{

    /**
     * @param UpdateCategoryRequest $request
     * @return Category
     * @throws RepositorySaveException
     * @throws ValidationException
     * @throws NoPermissionException
     * @throws CategoryNotFoundException
     */
    public function update(UpdateCategoryRequest $request): Category;

}