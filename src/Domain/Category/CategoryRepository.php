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
     * @return User|null
     */
    public function get($id): ?User;

    /**
     * @param User $user
     */
    public function save(User $user);

    /**
     * @param User $user
     */
    public function delete(User $user);

}