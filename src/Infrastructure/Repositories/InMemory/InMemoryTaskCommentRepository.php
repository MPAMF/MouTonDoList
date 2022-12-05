<?php

namespace App\Infrastructure\Repositories\InMemory;

use App\Domain\Models\Task\Task;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Repositories\TaskCommentRepository;

class InMemoryTaskCommentRepository implements TaskCommentRepository
{

    public function getUserComments(int $user_id, ?array $with = null): array
    {
        return [];
    }

    public function getTaskComments(int $task_id, ?array $with = null): array
    {
        return [];
    }

    public function get($id, ?array $with = null): TaskComment
    {
        return new TaskComment();
    }

    public function save(TaskComment $taskComment): bool
    {
        return false;
    }

    public function delete(TaskComment $taskComment): int
    {
        return 0;
    }

    public function exists(int $id): bool
    {
        return false;
    }
}