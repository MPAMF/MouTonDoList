<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Exception;
use Illuminate\Database\DatabaseManager;

class EloquentUserRepository extends Repository implements UserRepository
{

    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * {@inheritdoc}
     */
    public function logUser(string $email, string $password): User
    {
        $found = $this->getTable()->where('email', $email)->first();

        if (empty($found) || !password_verify($password, $found->password)) {
            throw new UserNotFoundException();
        }

        $parsed = new User();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($found);
        } catch (Exception) {
            throw new UserNotFoundException();
        }

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = null, array|null &$cache = null): User
    {
        // Return cached values to avoid multiple db requests
        if (isset($cache['users'][$id]))
            return $cache['users'][$id];

        $found = $this->getTable()->where('id', $id)->first();

        if (empty($found)) {
            throw new UserNotFoundException();
        }

        $parsed = new User();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($found);
        } catch (Exception) {
            throw new UserNotFoundException();
        }

        // Write to cache
        if (!isset($cache))
            $cache = [];

        $cache['users'][$id] = $parsed;

        return $parsed;
    }

    public function save(User $user): bool
    {
        return $this->getTable()->updateOrInsert(
            $user->toRow()
        );
    }

    public function delete(User $user): int
    {
        return $this->getTable()->delete($user->getId());
    }

    public function exists($id): bool
    {
        return $this->getTable()->where('id', $id)->exists();
    }
}
