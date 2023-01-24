<?php

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\DbCacheInterface;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Infrastructure\Repositories\Repository;
use App\Infrastructure\Repositories\TaskCommentRepository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;
use Exception;
use stdClass;

class EloquentTaskCommentRepository extends Repository implements TaskCommentRepository
{

    /**
     * @Inject
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @Inject
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @Inject
     * @var DbCacheInterface
     */
    private DbCacheInterface $dbCache;

    public function __construct()
    {
        parent::__construct('task_comments');
    }

    /**
     * @param stdClass|null $taskComment
     * @param array|null $with
     * @return TaskComment
     * @throws TaskCommentNotFoundException
     */
    private function parseTaskComment(stdClass|null $taskComment, array|null $with = ['author', 'task']): TaskComment
    {
        if (!isset($taskComment)) {
            throw new TaskCommentNotFoundException();
        }

        if (empty($taskComment->author_id) || $with == null || !in_array('author', $with)) {
            $taskComment->author = null;
        } else {
            try {
                $taskComment->author = $this->userRepository->get($taskComment->author_id, $with);
            } catch (UserNotFoundException) {
                $taskComment->author = null;
            }
        }

        if ($with == null || !in_array('task', $with)) {
            $taskComment->task = null;
        } else {
            try {
                $taskComment->task = $this->taskRepository->get($taskComment->task_id, $with);
            } catch (TaskNotFoundException) {
                $taskComment->task = null;
            }
        }

        $parsed = new TaskComment();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($taskComment);
        } catch (Exception) {
            throw new TaskCommentNotFoundException();
        }

        // only save stdClass representation of model
        $this->dbCache->save($this->tableName, $parsed->getId(), $parsed->toRow());

        return $parsed;
    }

    /**
     * @param int $id
     * @param bool $user
     * @param array|null $with
     * @return array
     */
    private function getComments(int $id, bool $user = false, array|null $with = null): array
    {
        $comments = [];

        $foundComments = $this->getTable()
            ->where($user ? 'user_id' : 'task_id', $id)
            ->latest()
            ->get();

        foreach ($foundComments as $comment) {

            try {
                $comments[] = $this->parseTaskComment($comment, $with);
            } catch (TaskCommentNotFoundException) {
                // do nothing
            }

        }

        return $comments;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserComments(int $user_id, array|null $with = null): array
    {
        return $this->getComments($user_id, true, $with);
    }

    /**
     * {@inheritDoc}
     */
    public function getTaskComments(int $task_id, array|null $with = null): array
    {
        return $this->getComments($task_id, false, $with);
    }

    /**
     * {@inheritDoc}
     */
    public function get($id, array|null $with = null): TaskComment
    {
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getTable()->where('id', $id)->first();
        if(is_array($found)) $found = (object) $found;
        return $this->parseTaskComment($found, $with);
    }

    /**
     * {@inheritDoc}
     */
    public function save(TaskComment $taskComment): bool
    {
        // Create
        if ($taskComment->getId() == null) {
            $id = $this->getTable()->insertGetId($taskComment->toRow());
            $taskComment->setId($id);
            return $id != 0;
        }

        $this->getTable()->where('id', $taskComment->getId())
                ->update($taskComment->toRow());
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(TaskComment $taskComment): int
    {
        return $this->getTable()->delete($taskComment->getId());
    }

    /**
     * {@inheritDoc}
     */
    public function exists(int $id): bool
    {
        return $this->getTable()->where('id', $id)->exists();
    }

}