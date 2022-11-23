<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\DbCacheInterface;
use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use DI\Annotation\Inject;
use Exception;
use Illuminate\Database\DatabaseManager;
use stdClass;

class EloquentTaskRepository extends Repository implements TaskRepository
{

    /**
     * @Inject()
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @Inject()
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @Inject()
     * @var DbCacheInterface
     */
    private DbCacheInterface $dbCache;

    public function __construct() {
        parent::__construct('tasks');
    }

    /**
     * @param stdClass $task
     * @param array|null $with
     * @return Task
     * @throws TaskNotFoundException
     */
    private function parseTask(stdClass|null $task, array|null $with = ['category', 'lastEditor', 'assigned']): Task
    {
        if (!isset($task)) {
            throw new TaskNotFoundException();
        }

        if ($with == null || !in_array('category', $with)) {
            $task->category = null;
        } else {
            try {
                $task->category = $this->categoryRepository->get($task->category_id, $with);
            } catch (CategoryNotFoundException) {
                // Should never happen.
                throw new TaskNotFoundException();
            }
        }

        if (!isset($task->assigned_id) || $with == null || !in_array('assigned', $with)) {
            $task->assigned = null;
        } else {
            try {
                $task->assigned = $this->userRepository->get($task->assigned_id, $with);
            } catch (UserNotFoundException) {
                $task->assigned = null;
                $task->assigned_id = null;
            }
        }

        if (!isset($task->last_editor_id) || $with == null || !in_array('lastEditor', $with)) {
            $task->last_editor = null;
        } else {
            try {
                $task->last_editor = $this->userRepository->get($task->last_editor_id, $with);
            } catch (UserNotFoundException) {
                $task->last_editor = null;
                $task->last_editor_id = null;
            }
        }

        $parsed = new Task();
        // If there's a parsing error, just show the usercategory a not found exception.
        try {
            $parsed->fromRow($task);
        } catch (Exception) {
            throw new TaskNotFoundException();
        }

        $this->dbCache->save($this->tableName, $parsed->getId(), $parsed->toRow());

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = null): Task
    {
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getTable()->where('id', $id)->first();
        return $this->parseTask($found, $with);
    }

    public function save(Task $task) : bool
    {
        return $this->getTable()->updateOrInsert(
            $task->toRow()
        );
    }

    public function delete(Task $task) : int
    {
        return $this->getTable()->delete($task->getId());
    }

    public function getTasks(int|Category $category, array|null $with = null): array
    {
        $tasks = [];
        $id = $category instanceof Category ? $category->getId() : $category;

        $foundTasks = $this->getTable()
            ->where('category_id', $id)
            ->orderBy('position')
            ->get();

        foreach ($foundTasks as $task) {

            try {
                $tasks[] = $this->parseTask($task, $with);
            } catch (TaskNotFoundException) {
                // do nothing
            }

        }

        return $tasks;
    }
}
