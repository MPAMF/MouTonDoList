<?php

namespace App\Domain\Services\Models\Category;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\CreateCategoryRequest;

interface CreateCategoryService
{

    /**
     * @param CreateCategoryRequest $request
     * @return Category
     * @throws RepositorySaveException
     * @throws BadRequestException
     * @throws NoPermissionException
     * @throws ValidationException
     */
    public function create(CreateCategoryRequest $request): Category;
}
