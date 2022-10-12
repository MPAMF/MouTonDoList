<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Repository;
use DateTime;
use Illuminate\Database\DatabaseManager;

class EloquentUserRepository extends Repository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(DatabaseManager $db, array $users = null)
    {
        parent::__construct($db);
        $datetime = new DateTime();
        $this->users = $users ?? [
            1 => new User(1, 'bill.gates', 'Bill', 'Gates', $datetime, $datetime),
            2 => new User(2, 'steve.jobs', 'Steve', 'Jobs', $datetime, $datetime),
            3 => new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg', $datetime, $datetime),
            4 => new User(4, 'evan.spiegel', 'Evan', 'Spiegel', $datetime, $datetime),
            5 => new User(5, 'jack.dorsey', 'Jack', 'Dorsey', $datetime, $datetime),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function logUser(string $email, string $password): ?User
    {
        $found = $this->getDB()->table('users')->where('email', $email)->where('password', $password)->first();
        // TODO: Implement logUser() method.
        return null;
    }
}
