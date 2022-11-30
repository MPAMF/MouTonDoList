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
     * @param bool|null $accepted Categories including invited categories
     * @param array|null $with ['user', 'category'] load objects
     * @return array Categories from user
     */
    public function getCategories(User|int $user, ?bool $accepted = null, array|null $with = null) : array;

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
     * @param int $id
     * @param array|null $with ['user', 'category'] load objects
     * @return UserCategory
     * @throws UserCategoryNotFoundException
     */
    public function get(int $id, array|null $with = null): UserCategory;

    /**
     * @param int|Category $category
     * @param array|null $with
     * @return array
     */
    public function getUsers(int|Category $category, array|null $with = null): array;

}
