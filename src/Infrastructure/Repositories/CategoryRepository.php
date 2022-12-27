<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;

interface CategoryRepository
{

    /**
     * Get all sub-categories from a parent category
     * @param $parentCategoryId
     * @param array|null $with Load parentCategory or owner from db, example: ['parentCategory, 'owner']
     * @return array
     */
    public function getSubCategories($parentCategoryId, array|null $with = null): array;

    /**
     * @param $id
     * @param array|null $with Load parentCategory or owner from db, example: ['parentCategory, 'owner']
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function get($id, array|null $with = null): Category;

    /**
     * @param Category $category
     * @return bool Save or update is successful
     */
    public function save(Category $category): bool;

    /**
     * @param Category $category
     * @return int Number of records deleted
     */
    public function delete(Category $category): int;

    /**
     * @param int $user_id
     * @param array|null $with Load parentCategory or owner from db, example: ['parentCategory, 'owner']
     * @return Category|null Returns last edited category (not sub-categories)
     */
    public function getLastUpdatedCategory(int $user_id, array|null $with = null): ?Category;

    /**
     * @param int|null $id
     * @param int|null $parentCategoryId
     * @return bool
     */
    public function exists(?int $id, ?int $parentCategoryId = null): bool;
}
