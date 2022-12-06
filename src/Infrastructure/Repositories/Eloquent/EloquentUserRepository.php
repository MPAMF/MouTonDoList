<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\DbCacheInterface;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Models\User\UserRepository;
use App\Infrastructure\Repositories\Repository;
use Exception;
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
     * @param stdClass|null $user
     * @param array|null $with
     * @return User
     * @throws UserNotFoundException
     */
    private function parseUser(stdClass|null $user, array|null $with = null): User
    {
        if (!isset($user)) {
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
        if (is_array($found)) $found = (object)$found;
        return $this->parseUser($found, $with);
    }

    public function save(User $user): bool
    {
        // Create
        if ($user->getId() == null) {
            $id = $this->getTable()->insertGetId($user->toRow());
            $user->setId($id);
            return $id != 0;
        }

        return $this->getTable()->where('id', $user->getId())
                ->update($user->toRow()) != 0;
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
