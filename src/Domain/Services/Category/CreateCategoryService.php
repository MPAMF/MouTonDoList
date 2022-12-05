<?php

namespace App\Domain\Services\Category;

use App\Domain\Models\Category\Category;

interface CreateCategoryService
{

    public function create() : Category;

}