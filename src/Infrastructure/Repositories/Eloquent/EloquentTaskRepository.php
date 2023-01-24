<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\DbCacheInterface;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\Repository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;
use Exception;
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

    public function __construct()
    {
        parent::__construct('tasks');
    }

    /**
     * @param stdClass|null $task
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
        if (is_array($found)) $found = (object)$found;
        return $this->parseTask($found, $with);
    }

    public function save(Task $task): bool
    {
        // Create
        if ($task->getId() == null) {
            $id = $this->getTable()->insertGetId($task->toRow());
            $task->setId($id);
            return $id != 0;
        }

        $this->getTable()->where('id', $task->getId())
                ->update($task->toRow());
        return true;
    }

    public function delete(Task $task): int
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

    /**
     * {@inheritDoc}
     * @param bool $isDelete
     * @param int $newPosition
     * @param int $oldPosition
     */
    public function orderTasks(Task $task, int $newPosition, int $oldPosition, bool $isDelete): bool
    {

        if ($isDelete) {
            return $this->getTable()
                    ->where('category_id', $task->getCategoryId())
                    ->where('position', '>', $oldPosition)
                    ->decrement('position') != 0;
        }

        if ($newPosition == $oldPosition)
            return true;

        // First check if task position is not greater than the highest position in db
        $highest = $this->getTable()
            ->where('id', '!=', $task->getId())
            ->where('category_id', $task->getCategoryId())
            ->max('position');

        if (empty($highest)) {
            $task->setPosition(0);
        } else if ($task->getPosition() >= $highest + 1) { // If higher, then set to last position +1
            $task->setPosition($highest + 1);
        } else {
            // si newPosition < oldPosition: update all pos + 1 where position > newPosition && position < oldPosition
            // 0 <-|    //  3 -> 0
            // 1   ^    // 0 -> 1
            // 2   ^    // 1 -> 2
            // 3 ->|    // 2 -> 3
            // 4

            $query = $this->getTable()
                ->where('id', '!=', $task->getId())
                ->where('category_id', $task->getCategoryId());

            // when add
            if ($oldPosition < 0) {
                return $query->where('position' ,'>=', $newPosition)
                        ->increment('position') != 0;
            }

            if ($newPosition < $oldPosition) {
                return $query->where('position', '>=', $newPosition)
                        ->where('position', '<', $oldPosition)
                        ->increment('position') != 0;
            }
            // si newPosition > oldPosition => update all pos - 1 where position > oldPosition && position < newPosition
            // 0 >-|    // 0 -> 3
            // 1   |    // 1 -> 0
            // 2   |    // 2 -> 1
            // 3 <-|    // 3 -> 2
            // 4
            return $query->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->decrement('position') != 0;
        }

        // Check if task position is not greater than the highest position in db
        return $this->getTable()
                ->where('id', $task->getId())
                ->update(['position' => $task->getPosition()]) != 0;
    }

}
