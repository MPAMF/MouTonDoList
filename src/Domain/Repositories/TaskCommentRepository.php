<?php
declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;

interface TaskCommentRepository
{

    /**
     * @param int $user_id
     * @param array|null $with Load instances of 'author' or/and 'task'
     * @return array All comments of a user
     */
    public function getUserComments(int $user_id, array|null $with = null) : array;

    /**
     * @param int $task_id
     * @param array|null $with Load instances of 'author' or/and 'task'
     * @return array All comments of a task
     */
    public function getTaskComments(int $task_id, array|null $with = null) : array;

    /**
     * @param $id
     * @param array|null $with Load instances of 'author' or/and 'task'
     * @return TaskComment
     * @throws TaskCommentNotFoundException
     */
    public function get($id, array|null $with = null): TaskComment;

    /**
     * @param TaskComment $taskComment
     * @return bool Save or update is successful
     */
    public function save(TaskComment $taskComment): bool;

    /**
     * @param TaskComment $taskComment User
     * @return int Number of records deleted
     */
    public function delete(TaskComment $taskComment) : int;

    /**
     * @param int $id TaskComment id
     * @return bool User exists
     */
    public function exists(int $id): bool;
}
