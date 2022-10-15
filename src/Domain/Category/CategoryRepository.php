<?php

namespace App\Domain\Category;

use App\Domain\User\User;

interface CategoryRepository
{

    /**
     * @param User $user
     * @return array
     */
    public function getCategories(User $user) : array;

    /**
     * @param $id
     * @return Category|null
     */
    public function get($id): ?Category;

    /**
     * @param Category $category
     */
    public function save(Category $category);

    /**
     * @param Category $category
     */
    public function delete(Category $category);

}