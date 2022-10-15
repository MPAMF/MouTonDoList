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
     */
    public function save(Task $task);

    /**
     * @param Task $task
     */
    public function delete(Task $task);

}