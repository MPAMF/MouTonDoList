<?php
declare(strict_types=1);

namespace App\Domain\UserCategory;

use App\Domain\Category\Category;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;

interface UserCategoryRepository
{

    /**
     * @param User|int $user User or user_id
     * @param array|null $with ['user'] load user object
     * @return array Categories from user
     */
    public function getCategories(User|int $user, array|null $with = null) : array;

    /**
     * @param UserCategory $userCategory User category
     * @return int Number of records deleted
     */
    public function delete(UserCategory $userCategory) : int;

    /**
     * @param UserCategory $userCategory User category
     * @return bool Save or update is successful
     */
    public function save(UserCategory $userCategory): bool;

    /**
     * @param $id
     * @return UserCategory
     * @throws UserCategoryNotFoundException
     */
    public function get($id): UserCategory;

}
