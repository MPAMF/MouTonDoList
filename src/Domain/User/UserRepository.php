<?php
declare(strict_types=1);

namespace App\Domain\User;

use Exception;
use stdClass;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function logUser(string $email, string $password): ?User;

    /**
     * @param stdClass $result
     * @return User|null
     * @throws Exception
     */
    public function parseUserFromDb(stdClass $result) : ?User;

}
