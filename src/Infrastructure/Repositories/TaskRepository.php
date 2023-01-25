<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;

interface TaskRepository
{

    /**
     * @param int|Category $category ID or category object
     * @param array|null $with ['category', 'last_editor', 'assigned'] load objects
     * @return array
     */
    public function getTasks(int|Category $category, array|null $with = null): array;

    /**
     * @param $id
     * @param array|null $with ['category', 'last_editor', 'assigned'] load objects
     * @return Task|null
     * @throws TaskNotFoundException
     */
    public function get($id, array|null $with = null): ?Task;

    /**
     * @param Task $task
     * @return bool Save or update is successful
     */
    public function save(Task $task): bool;

    /**
     * @param Task $task
     * @return int Number of records deleted
     */
    public function delete(Task $task): int;

    /**
     * @param Task $task
     * @param int $newPosition
     * @param int $oldPosition
     * @param bool $isDelete
     * @return bool
     */
    public function orderTasks(Task $task, int $newPosition, int $oldPosition, bool $isDelete): bool;

    /**
     * @param string $name
     * @param int $userId
     * @param array|null $with
     * @return array
     */
    public function searchTasks(string $name, int $userId, array|null $with = null) : array;

}
