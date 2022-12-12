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
     * @param string $password
     */
    public function setPassword(string $password): void
    {
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
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPasswordConf(): string
    {
        return $this->passwordConf;
    }

    /**
     * @param string $passwordConf
     */
    public function setPasswordConf(string $passwordConf): void
    {
        $this->passwordConf = $passwordConf;
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