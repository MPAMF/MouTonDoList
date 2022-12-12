<?php
declare(strict_types=1);

namespace App\Domain\Models\Task;

use App\Domain\Models\Category\Category;
use App\Domain\Models\TimeStampedModel;
use App\Domain\Models\User\User;
use App\Domain\Models\ValidatorModel;
use DateTime;
use JsonSerializable;
use Respect\Validation\Validator;
use ReturnTypeWillChange;
use stdClass;

class Task extends TimeStampedModel implements JsonSerializable, ValidatorModel
{
    private ?int $id;
    private int $category_id;
    private string $name;
    private ?Category $category;
    private string $description;
    private DateTime $due_date;
    private bool $checked;
    private int $position;
    private ?int $last_editor_id;
    private ?User $last_editor;
    private ?int $assigned_id;
    private ?User $assigned;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->category = null;
        $this->category_id = 0;
        $this->name = "";
        $this->description = "";
        $this->due_date = new DateTime();
        $this->checked = false;
        $this->position = 0;
        $this->last_editor = null;
        $this->last_editor_id = null;
        $this->assigned = null;
        $this->assigned_id = null;
    }

    public static function getValidatorRules(): array
    {
        return [
            'category_id' => Validator::intType(),
            'name' => Validator::notEmpty()->stringType()->length(min: 3, max: 63),
            'description' => Validator::stringType()->length(max: 1024),
            'due_date' => Validator::dateTime('Y-m-d H:i:s'),
            'checked' => Validator::boolVal(),
            'position' => Validator::intType(), // limit
            'assigned_id' => Validator::oneOf(Validator::nullType(), Validator::intType()),
        ];
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getDueDate(): DateTime
    {
        return $this->due_date;
    }

    /**
     * @param DateTime $due_date
     */
    public function setDueDate(DateTime $due_date): void
    {
        $this->due_date = $due_date;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * @param bool $checked
     */
    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
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
     * @return User|null
     */
    public function getLastEditor(): ?User
    {
        return $this->last_editor;
    }

    /**
     * @param User|null $last_editor
     */
    public function setLastEditor(?User $last_editor): void
    {
        $this->last_editor = $last_editor;
        $this->last_editor_id = $last_editor?->getId();
    }

    /**
     * @return int|null
     */
    public function getLastEditorId(): ?int
    {
        return $this->last_editor_id;
    }

    /**
     * @param int|null $last_editor_id
     */
    public function setLastEditorId(?int $last_editor_id): void
    {
        $this->last_editor_id = $last_editor_id;
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
     * @return User|null
     */
    public function getAssigned(): ?User
    {
        return $this->assigned;
    }

    /**
     * @param User|null $assigned
     */
    public function setAssigned(?User $assigned): void
    {
        $this->assigned = $assigned;
        $this->assigned_id = $assigned?->getId();
    }

    /**
     * @return int|null
     */
    public function getAssignedId(): ?int
    {
        return $this->assigned_id;
    }

    /**
     * @param int|null $assigned_id
     */
    public function setAssignedId(?int $assigned_id): void
    {
        $this->assigned_id = $assigned_id;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        // stdClass must have loaded instances of other models
        $this->category = $row->category ?? null;
        $this->last_editor = $row->last_editor ?? null;
        $this->assigned = $row->assigned ?? null;
        $this->fromValidator($row);
    }

    public function fromValidator(array|object $data): void
    {
        $this->category_id = intval($data->category_id);
        $this->name = $data->name;
        $this->description = $data->description;
        $this->due_date = DateTime::createFromFormat('Y-m-d H:i:s', $data->due_date);
        $this->checked = boolval($data->checked);
        $this->position = intval($data->position);
        $this->last_editor_id = isset($data->last_editor_id) ? intval($data->last_editor_id) : null;
        $this->assigned_id = isset($data->assigned_id) ? intval($data->assigned_id) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $row = $this->jsonSerialize();
        unset($row['category']);
        unset($row['last_editor']);
        unset($row['assigned']);
        unset($row['comments']);
        return $row;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $result = [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => isset($this->category) ? $this->category->jsonSerialize() : null,
            'name' => $this->name,
            'description' => $this->description,
            'due_date' => $this->due_date->format('Y-m-d H:i:s'),
            'checked' => $this->checked,
            'position' => $this->position,
            'last_editor_id' => $this->last_editor_id,
            'last_editor' => isset($this->last_editor) ? $this->last_editor->jsonSerialize() : null,
            'assigned_id' => $this->assigned_id,
            'assigned' => isset($this->assigned) ? $this->assigned->jsonSerialize() : null
        ];

        if (isset($this->comments)) {
            $result['comments'] = $this->comments;
        }

        return $result;
    }
}
