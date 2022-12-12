<?php

namespace App\Infrastructure\Repositories\InMemory;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Task\Task;
use App\Infrastructure\Repositories\TaskRepository;

class InMemoryTaskRepository implements TaskRepository
{

    public function getTasks(Category|int $category, ?array $with = null): array
    {
        return [];
    }

    public function get($id, ?array $with = null): ?Task
    {
        return null;
    }

    public function save(Task $task): bool
    {
        return false;
    }

    public function delete(Task $task): int
    {
        return 0;
    }
}