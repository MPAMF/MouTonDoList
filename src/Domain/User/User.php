<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\TimeStampedModel;
use JsonSerializable;

class User extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;

    // Primary key & unique
    private string $email;

    private string $username;

    private string $password;

    // Options
    private string $image_path;
    private string $theme;
    private string $language;

    public function __construct(
        ?int      $id,
        string $email,
        string $username,
        string $password,
        \DateTime $updated_at,
        \DateTime $created_at
    ) {
        parent::__construct($updated_at, $created_at);
        $this->id = $id;
        $this->email = $email;
        $this->username = strtolower($username);
        $this->password = $password; // Don't forget to hash password
        //
        $this->image_path = "";
        $this->theme = "";
        $this->language = "";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
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
    public function getImagePath(): string
    {
        return $this->image_path;
    }

    /**
     * @param string $image_path
     */
    public function setImagePath(string $image_path): void
    {
        $this->image_path = $image_path;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'image_path' => $this->image_path,
            'theme' => $this->theme,
            'language' => $this->language,
        ];
    }
}
