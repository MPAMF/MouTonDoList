<?php
declare(strict_types=1);

namespace App\Domain\User;

use Exception;
use stdClass;

interface UserRepository
{

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws UserNotFoundException
     */
    public function logUser(string $email, string $password): User;

    /**
     * @param stdClass $result
     * @return User|null
     * @throws Exception
     */
    public function parseUserFromDb(stdClass $result) : ?User;

}
