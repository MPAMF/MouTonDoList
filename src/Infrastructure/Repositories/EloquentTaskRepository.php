<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Exception;
use Illuminate\Database\DatabaseManager;

class EloquentTaskRepository extends Repository implements TaskRepository
{

    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;

    /**
     * @param DatabaseManager $db
     * @param UserRepository $userRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        DatabaseManager $db,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($db);
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id): Task
    {
        // to chiant to make two left joins : 3 requests are better
        $task = $this->getDB()->table('tasks')
            ->where('id', $id)
            ->first();

        if (empty($task)) {
            throw new TaskNotFoundException();
        }

        try {
            $task->category = $this->categoryRepository->get($task->category_id);
        } catch (CategoryNotFoundException) {
            $task->category = null; // Should never happen.
        }

        if (empty($task->last_editor_id)) {
            $task->last_editor = null;
        } else {
            try {
                $task->last_editor = $this->userRepository->get($task->last_editor_id);
            } catch (UserNotFoundException) {
                $task->last_editor = null;
            }
        }

        $parsed = new Task();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($task);
        } catch (Exception) {
            throw new TaskNotFoundException();
        }

        return $parsed;
    }

    public function save(Task $task) : bool
    {
        return $this->getDB()->table('tasks')->updateOrInsert(
            $task->toRow()
        );
    }

    public function delete(Task $task) : int
    {
        return $this->getDB()->table('tasks')->delete($task->getId());
    }

    public function getTasks(Category $category): array
    {
        return [];
    }
}
