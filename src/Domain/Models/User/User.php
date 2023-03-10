<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\TimeStampedModel;
use App\Domain\Models\ValidatorModel;
use DateTime;
use JsonSerializable;
use Respect\Validation\Validator;
use ReturnTypeWillChange;
use stdClass;

/**
 * @OA\Schema(title="User")
 */
class User extends TimeStampedModel implements JsonSerializable, ValidatorModel
{
    /**
     * @var int|null
     * @OA\Property()
     */
    private ?int $id;

    /**
     * @var string
     * @OA\Property()
     */
    // Primary key & unique
    private string $email;

    /**
     * @var string
     * @OA\Property()
     */
    private string $username;

    /**
     * @var string
     * @OA\Property()
     */
    private string $password;

    // Options
    /**
     * @var string
     * @OA\Property()
     */
    private string $image_path;
    /**
     * @var string
     * @OA\Property()
     */
    private string $theme;
    /**
     * @var string
     * @OA\Property()
     */
    private string $language;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->email = "";
        $this->username = "";
        $this->password = ""; // Don't forget to hash password
        //
        $this->image_path = "";
        $this->theme = "";
        $this->language = "";
    }

    public static function getValidatorRules(): array
    {
        return [
            'email' => Validator::notBlank()->email()->length(0, 254),
            'username' => Validator::notBlank()->length(0, 64),
            'password' => Validator::notBlank()->regex('/[A-Z]/')->regex('/[a-z]/')
                ->regex('/[1-9]/')->regex('/[-_*.!?#@&]/')->length(6, 128),
            'image_path' => Validator::url(),
            'theme' => Validator::stringType()->length(max: 16),
            'language' => Validator::stringType()->length(max: 16)
        ];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->password = $row->password;
        $this->fromValidator($row);
    }

    public function fromValidator(object|array $data): void
    {
        $data = (object)$data;
        $this->email = $data->email;
        $this->username = $data->username;
        $this->password = $data->password;
        $this->image_path = $data->image_path;
        $this->theme = $data->theme;
        $this->language = $data->language;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $row = $this->jsonSerialize();
        $row['password'] = $this->password;
        return $row;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'image_path' => $this->image_path,
            'theme' => $this->theme,
            'language' => $this->language
        ];
    }
}
