<?php
declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Category\Category;
use App\Domain\EloquentModel;
use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;
use stdClass;

class Task extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;
    private Category $category;
    private string $description;
    private DateTime $due_date;
    private bool $checked;
    private int $position;
    private ?User $last_editor;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->category = new Category();
        $this->description = "";
        $this->due_date = new DateTime();
        $this->checked = false;
        $this->position = 0;
        $this->last_editor = null;
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
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
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category->getId(),
            'description' => $this->description,
            'due_date' => $this->due_date,
            'checked' => $this->checked,
            'position' => $this->position,
            'last_editor_id' => isset($this->last_editor) ? $this->last_editor->getId() : '',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        // stdClass must have loaded instances of other models
        $this->category = $row->category;
        $this->description = $row->description;
        $this->due_date = new DateTime($row->due_date);
        $this->checked = $row->checked;
        $this->position = $row->position;
        $this->last_editor = $row->last_editor;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        return $this->jsonSerialize();
    }
}
