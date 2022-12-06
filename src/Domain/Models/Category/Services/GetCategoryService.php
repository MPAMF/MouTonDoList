<?php

namespace App\Domain\Models\Category\Services;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\Requests\GetCategoryRequest;

interface GetCategoryService
{

    /**
     * @param GetCategoryRequest $request
     * @return Category
     * @throws CategoryNotFoundException
     * @throws NoPermissionException
     */
    public function get(GetCategoryRequest $request) : Category;

}