<?php
declare(strict_types=1);

namespace App\Domain\TaskComment;

use Exception;
use stdClass;

interface TaskCommentRepository
{

    /**
     * @param string $email
     * @param string $password
     * @return TaskComment
     * @throws TaskCommentNotFoundException
     */
    public function logUser(string $email, string $password): TaskComment;

    /**
     * @param $id
     * @return TaskComment
     * @throws TaskCommentNotFoundException
     */
    public function get($id): TaskComment;

    /**
     * @param TaskComment $user
     * @return bool Save or update is successful
     */
    public function save(TaskComment $user): bool;

    /**
     * @param TaskComment $user User
     * @return int Number of records deleted
     */
    public function delete(TaskComment $user) : int;

    /**
     * @param $id TaskComment id
     * @return bool User exists
     */
    public function exists($id): bool;
}
