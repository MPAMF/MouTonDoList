<?php
declare(strict_types=1);

namespace App\Domain\Models\Category;

use App\Domain\Models\TimeStampedModel;
use App\Domain\Models\User\User;
use App\Domain\Models\ValidatorModel;
use DateTime;
use JsonSerializable;
use Respect\Validation\Validator;
use ReturnTypeWillChange;
use stdClass;

/**
 * @OA\Schema(title="Category")
 */
class Category extends TimeStampedModel implements JsonSerializable, ValidatorModel
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
    private int $owner_id;
    private ?User $owner;

    /**
     * @var int|null
     * @OA\Property()
     */
    private ?int $parent_category_id;
    private ?Category $parentCategory;

    /**
     * @var string
     * @OA\Property()
     */
    private string $name;

    /**
     * @var string
     * @OA\Property()
     */
    private string $color;

    /**
     * @var int
     * @OA\Property()
     */
    private int $position;

    /**
     * @var bool
     * @OA\Property()
     */
    private bool $archived;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->owner_id = 0;
        $this->owner = null;
        $this->parent_category_id = null;
        $this->parentCategory = null;
        $this->name = "";
        $this->color = "";
        $this->position = 0;
        $this->archived = false;
    }

    public static function getValidatorRules(): array
    {
        return [
            'archived' => Validator::boolVal(),
            'position' => Validator::intType(), // limit
            'name' => Validator::notEmpty()->stringType()->length(min: 3, max: 63),
            'color' => Validator::notEmpty()->stringType()->length(max: 15),
            'parent_category_id' => Validator::oneOf(Validator::nullType(), Validator::intType())
        ];
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     */
    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
        $this->owner_id = $owner?->getId();
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
    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    /**
     * @param Category|null $parentCategory
     */
    public function setParentCategory(?Category $parentCategory): void
    {
        $this->parentCategory = $parentCategory;
        $this->parent_category_id = $parentCategory?->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     */
    public function setArchived(bool $archived): void
    {
        $this->archived = $archived;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     */
    public function setOwnerId(int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return int|null
     */
    public function getParentCategoryId(): ?int
    {
        return $this->parent_category_id;
    }

    /**
     * @param int|null $parent_category_id
     */
    public function setParentCategoryId(?int $parent_category_id): void
    {
        $this->parent_category_id = $parent_category_id;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->owner_id = $row->owner_id;
        $this->owner = $row->owner ?? null;
        $this->parentCategory = $row->parentCategory ?? null;
        $this->fromValidator($row);
    }

    public function fromValidator(array|object $data): void
    {
        $data = (object)$data;
        $this->name = $data->name;
        $this->color = $data->color;
        $this->parent_category_id = isset($data->parent_category_id) ? intval($data->parent_category_id) : null;
        $this->position = intval($data->position);
        $this->archived = boolval($data->archived);
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $row = $this->jsonSerialize();
        unset($row['parent_category']);
        unset($row['owner']);
        unset($row['subCategories']);
        unset($row['tasks']);
        return $row;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): array
    {

        $result = [
            'id' => $this->id,
            'owner' => isset($this->owner) ? $this->owner->jsonSerialize() : null,
            'owner_id' => $this->owner_id,
            'parent_category' => isset($this->parentCategory) ? $this->parentCategory->jsonSerialize() : null,
            'parent_category_id' => $this->parent_category_id,
            'name' => $this->name,
            'color' => $this->color,
            'position' => $this->position,
            'archived' => $this->archived
        ];

        if (isset($this->subCategories)) {
            $result['subCategories'] = $this->subCategories;
        }

        if (isset($this->tasks)) {
            $result['tasks'] = $this->tasks;
        }

        return $result;
    }
}
