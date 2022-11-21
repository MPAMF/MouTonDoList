<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\TaskComment\TaskComment;
use App\Domain\TaskComment\TaskCommentNotFoundException;
use App\Domain\TaskComment\TaskCommentRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Exception;
use Illuminate\Database\DatabaseManager;
use stdClass;

class EloquentTaskCommentRepository extends Repository implements TaskCommentRepository
{

    private UserRepository $userRepository;
    private TaskRepository $taskRepository;

    public function __construct(DatabaseManager $db, UserRepository $userRepository, TaskRepository $taskRepository)
    {
        parent::__construct($db, 'tasks_comments');
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param stdClass $taskComment
     * @param array|null $with
     * @return TaskComment
     * @throws TaskCommentNotFoundException
     */
    private function parseTaskComment(stdClass $taskComment, array|null $with = ['author', 'task']): TaskComment
    {
        if (empty($taskComment)) {
            throw new TaskCommentNotFoundException();
        }

        if (empty($taskComment->author_id) || $with == null || !in_array('author', $with)) {
            $taskComment->author = null;
        } else {
            try {
                $taskComment->author = $this->userRepository->get($taskComment->author_id);
            } catch (UserNotFoundException) {
                $taskComment->author = null;
            }
        }

        if ($with == null || !in_array('task', $with)) {
            $taskComment->task = null;
        } else {
            try {
                $taskComment->task = $this->taskRepository->get($taskComment->task_id);
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
        $found = $this->getTable()->where('id', $id)->first();
        return $this->parseTaskComment($found, $with);
    }

    /**
     * {@inheritDoc}
     */
    public function save(TaskComment $taskComment): bool
    {
        return $this->getTable()->updateOrInsert(
            $taskComment->toRow()
        );
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