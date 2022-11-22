<?php

namespace App\Domain\Task;

use App\Domain\Category\Category;

interface TaskRepository
{

    /**
     * @param Category $category
     * @param array|null $with ['category', 'last_editor', 'assigned'] load objects
     * @return array
     */
    public function getTasks(Category $category, array|null $with = null) : array;

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
    public function save(Task $task) : bool;

    /**
     * @param Task $task
     * @return int Number of records deleted
     */
    public function delete(Task $task) : int;

}