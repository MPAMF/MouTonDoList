<?php
declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Models\Category\Category;
use App\Domain\Models\User\User;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;

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

    /**
     * @param int|null $id
     * @param int|null $categoryId
     * @param int|null $userId
     * @return bool
     */
    public function exists(?int $id, ?int $categoryId = null, ?int $userId = null, ?bool $accepted = null, ?bool $canEdit = null) : bool;

}
