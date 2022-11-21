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

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct($db);
    }

    /**
     * {@inheritdoc}
     */
    public function logUser(string $email, string $password): User
    {
        $found = $this->getDB()->table('users')->where('email', $email)->first();

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
    public function get($id): User
    {
        $found = $this->getDB()->table('users')->where('id', $id)->first();
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

        return $parsed;
    }

    public function save(User $user) : bool
    {
        return $this->getDB()->table('users')->updateOrInsert(
            $user->toRow()
        );
    }

    public function delete(User $user) : int
    {
        return $this->getDB()->table('users')->delete($user->getId());
    }

    public function exists($id): bool
    {
        return $this->getDB()->table('users')->where('id', $id)->exists();
    }
}
