<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\DbCacheInterface;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use DI\Annotation\Inject;
use Exception;
use Illuminate\Database\DatabaseManager;
use stdClass;

class EloquentUserRepository extends Repository implements UserRepository
{

    /**
     * @Inject()
     * @var DbCacheInterface
     */
    private DbCacheInterface $dbCache;

    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * @param stdClass $user
     * @param array|null $with
     * @return User
     * @throws UserNotFoundException
     */
    private function parseUser(stdClass $user, array|null $with = null): User
    {
        if (empty($user)) {
            throw new UserNotFoundException();
        }

        $parsed = new User();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($user);
        } catch (Exception) {
            throw new UserNotFoundException();
        }

        $this->dbCache->save($this->tableName, $parsed->getId(), $parsed->toRow());

        return $parsed;
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

        return $this->parseUser($found);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = null): User
    {
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getTable()->where('id', $id)->first();
        return $this->parseUser($found, $with);
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
