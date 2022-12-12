<?php

namespace App\Infrastructure\Repositories\InMemory;

use App\Domain\Models\User\User;
use App\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\Collection;

class InMemoryUserRepository implements UserRepository
{

    private Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function logUser(string $email, string $password): User
    {
        return new User();
    }

    public function get($id, ?array $with = null): User
    {
        return $this->users->first(fn(User $a) => $a->getId() == $id);
    }

    public function save(User $user): bool
    {
        return false;
    }

    public function delete(User $user): int
    {
        return 0;
    }

    public function exists($id): bool
    {
        return false;
    }
}