<?php

namespace App\Infrastructure\Repositories\InMemory;

use App\Domain\Models\Category\Category;
use App\Domain\Models\User\User;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryRepository;

class InMemoryUserCategoryRepository implements UserCategoryRepository
{

    public function getCategories(User|int $user, ?bool $accepted = null, ?array $with = null): array
    {
        return [];
    }

    public function delete(UserCategory $userCategory): int
    {
        return 0;
    }

    public function save(UserCategory $userCategory): bool
    {
        return false;
    }

    public function get(int $id, ?array $with = null): UserCategory
    {
        return new UserCategory();
    }

    public function getUsers(Category|int $category, ?array $with = null): array
    {
        return [];
    }

    public function exists(?int $id, ?int $categoryId = null, ?int $userId = null, ?bool $accepted = null, ?bool $canEdit = null): bool
    {
        return false;
    }
}