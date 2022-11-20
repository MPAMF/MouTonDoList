<?php

namespace App\Domain\Category;

use App\Domain\User\User;

interface CategoryRepository
{

    /**
     * Fetch only categories, not sub-categories
     * @param $user_id
     * @return array
     */
    public function getCategories($user_id) : array;

    /**
     * @param $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function get($id): Category;

    /**
     * @param Category $category
     * @return bool Save or update is successful
     */
    public function save(Category $category) : bool;

    /**
     * @param Category $category
     */
    public function delete(Category $category);

}