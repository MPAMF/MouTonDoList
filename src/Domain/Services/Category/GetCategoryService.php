<?php

namespace App\Domain\Services\Category;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\GetCategoryRequest;

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