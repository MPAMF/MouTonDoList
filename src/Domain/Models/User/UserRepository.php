<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

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
     * @param array|null $with
     * @return User
     * @throws UserNotFoundException
     */
    public function get($id, array|null $with = null): User;

    /**
     * @param User $user
     * @return bool Save or update is successful
     */
    public function save(User $user): bool;

    /**
     * @param User $user User
     * @return int Number of records deleted
     */
    public function delete(User $user) : int;

    /**
     * @param $id User id
     * @return bool User exists
     */
    public function exists($id): bool;
}