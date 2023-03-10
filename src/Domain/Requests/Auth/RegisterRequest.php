<?php

namespace App\Domain\Requests\Auth;

use App\Domain\Requests\Request;

class RegisterRequest implements Request
{

    private string $email;
    private string $username;
    private string $password;
    private string $passwordConf;

    /**
     * @param string $email
     * @param string $username
     * @param string $password
     * @param string $passwordConf
     */
    public function __construct(string $email, string $username, string $password, string $passwordConf)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->passwordConf = $passwordConf;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPasswordConf(): string
    {
        return $this->passwordConf;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'password-conf' => $this->passwordConf
        ];
    }

}