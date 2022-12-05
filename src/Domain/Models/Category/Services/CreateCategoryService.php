<?php

namespace App\Domain\Models\Category\Services;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\Requests\CreateCategoryRequest;

interface CreateCategoryService
{

    /**
     * @param CreateCategoryRequest $categoryRequest
     * @return Category
     * @throws RepositorySaveException
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws ValidationException
     */
    public function create(CreateCategoryRequest $categoryRequest) : Category;

}