<?php

namespace App\Domain\Task;

use App\Domain\Category\Category;

interface TaskRepository
{

    /**
     * @param Category $category
     * @return array
     */
    public function getTasks(Category $category) : array;

    /**
     * @param $id
     * @return Task|null
     * @throws TaskNotFoundException
     */
    public function get($id): ?Task;

    /**
     * @param Task $task
     * @return bool Save or update is successful
     */
    public function save(Task $task) : bool;

    /**
     * @param Task $task
     */
    public function delete(Task $task);

}