<?php

namespace App\Infrastructure\Repositories\InMemory;

use App\Domain\Models\Category\Category;
use App\Domain\Repositories\CategoryRepository;

class InMemoryCategoryRepository implements CategoryRepository
{

    public function getSubCategories($parentCategoryId, ?array $with = null): array
    {
        return [];
    }

    public function get($id, ?array $with = null): Category
    {
        return new Category();
    }

    public function save(Category $category): bool
    {
        return false;
    }

    public function delete(Category $category): int
    {
        return 0;
    }

    public function getLastUpdatedCategory(int $user_id, ?array $with = null): ?Category
    {
        return null;
    }

    public function exists(?int $id, ?int $parentCategoryId = null): bool
    {
        return false;
    }
}