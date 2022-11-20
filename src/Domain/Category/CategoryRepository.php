<?php

namespace App\Domain\Category;

interface CategoryRepository
{

    /**
     * Fetch only categories, not sub-categories
     * @param $user_id
     * @param array|null $with Load parentCategory or owner from db, example: ['parentCategory, 'owner']
     * @return array
     */
    public function getCategories($user_id, array|null $with = null) : array;

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
    public function save(Category $category) : bool;

    /**
     * @param Category $category
     */
    public function delete(Category $category);

    /**
     * @param int $user_id
     * @param array|null $with Load parentCategory or owner from db, example: ['parentCategory, 'owner']
     * @return Category|null Returns last edited category (not sub-categories)
     */
    public function getLastUpdatedCategory(int $user_id, array|null $with = null) : ?Category;

}