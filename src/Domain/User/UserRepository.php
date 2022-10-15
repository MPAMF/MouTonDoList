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
     * @param $id
     * @return User
     * @throws UserNotFoundException
     */
    public function get($id): User;

    /**
     * @param User $user
     */
    public function save(User $user);

    /**
     * @param User $user
     */
    public function delete(User $user);

}
