<?php

namespace App\Domain\Requests\Auth;

use App\Domain\Requests\Request;

class LoginRequest implements Request
{
    private string $email;
    private string $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getData(): ?array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}