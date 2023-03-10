<?php
declare(strict_types=1);

namespace App\Domain\Models\UserCategory;

use App\Domain\Models\Category\Category;
use App\Domain\Models\TimeStampedModel;
use App\Domain\Models\User\User;
use App\Domain\Models\ValidatorModel;
use DateTime;
use JsonSerializable;
use Respect\Validation\Validator;
use ReturnTypeWillChange;
use stdClass;

/**
 * @OA\Schema(title="UserCategory")
 * Other name: Invitation
 */
class UserCategory extends TimeStampedModel implements JsonSerializable, ValidatorModel
{
    /**
     * @var int|null
     * @OA\Property()
     */
    private ?int $id;

    /**
     * @var int
     * @OA\Property()
     */
    private int $user_id;
    private ?User $user;

    /**
     * @var int
     * @OA\Property()
     */
    private int $category_id;
    private ?Category $category;

    /**
     * @var bool
     * @OA\Property()
     */
    private bool $accepted;

    /**
     * @var bool
     * @OA\Property()
     */
    private bool $canEdit;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->accepted = false;
        $this->canEdit = false;
        $this->category_id = 0;
        $this->category = null;
        $this->user_id = 0;
        $this->user = null;
    }

    public static function getValidatorRules(): array
    {
        return [
            'accepted' => Validator::boolType(),
            'can_edit' => Validator::boolType(),
            'category_id' => Validator::intType(),
            'user_id' => Validator::optional(Validator::intType()),
            'email' => Validator::optional(Validator::email()),
        ];
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->user_id = $user->getId();
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
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->category_id = $category->getId();
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    /**
     * @param bool $accepted
     */
    public function setAccepted(bool $accepted): void
    {
        $this->accepted = $accepted;
    }

    /**
     * @return bool
     */
    public function isCanEdit(): bool
    {
        return $this->canEdit;
    }

    /**
     * @param bool $canEdit
     */
    public function setCanEdit(bool $canEdit): void
    {
        $this->canEdit = $canEdit;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->user = $row->user;
        $this->category = $row->category;
        $this->fromValidator($row);
    }

    public function fromValidator(object|array $data): void
    {
        $data = (object)$data;
        $this->user_id = intval($data->user_id);
        $this->category_id = $data->category_id;
        $this->accepted = boolval($data->accepted);
        $this->canEdit = boolval($data->can_edit);
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $result = $this->jsonSerialize();
        unset($result['user']);
        unset($result['category']);
        unset($result['members']);
        unset($result['created_at']);
        return $result;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $result = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => isset($this->user) ? $this->user->jsonSerialize() : null,
            'category_id' => $this->category_id,
            'category' => isset($this->category) ? $this->category->jsonSerialize() : null,
            'accepted' => $this->accepted,
            'can_edit' => $this->canEdit,
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s')
        ];

        if (isset($this->members)) {
            $result['members'] = $this->members;
        }

        return $result;
    }
}
