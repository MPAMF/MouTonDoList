<?php

namespace App\Domain\Requests;

use App\Domain\Models\User\User;

class DisplayDashboardRequest
{

    private ?int $id;
    private User $user;

    /**
     * @param int|null $id
     * @param User $user
     */
    public function __construct(?int $id, User $user)
    {
        $this->id = $id;
        $this->user = $user;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}