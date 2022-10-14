<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Repository;
use DateTime;
use Exception;
use Illuminate\Database\DatabaseManager;
use stdClass;

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
        $found = $this->getDB()->table('users')->where('email', $email)->where('password', $password)->first();
        if (empty($found)) {
            throw new UserNotFoundException();
        }

        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed = $this->parseUserFromDb($found);
        } catch (Exception) {
            throw new UserNotFoundException();
        }

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function parseUserFromDb(stdClass $result): ?User
    {
        $updated_at = new DateTime($result->updated_at);
        $created_at = new DateTime($result->created_at);
        return new User(
            $result->id,
            $result->email,
            $result->username,
            $result->password,
            $updated_at,
            $created_at
        );
    }
}
