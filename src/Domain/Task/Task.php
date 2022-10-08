<?php

namespace App\Domain\Task;

use App\Domain\Category\Category;
use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;

class Task extends TimeStampedModel implements JsonSerializable
{

    private ?int $id;
    private Category $category;
    private string $description;
    private DateTime $due_date;
    private bool $checked;
    private int $position;
    private ?User $last_editor;

    /**
     * @param int|null $id
     * @param Category $category
     * @param string $description
     * @param DateTime $due_date
     * @param bool $checked
     * @param int $position
     * @param User|null $last_editor
     */
    public function __construct(
        ?int $id,
        Category $category,
        string $description,
        DateTime $due_date,
        bool $checked,
        int $position,
        ?User $last_editor,
        DateTime $updated_at,
        DateTime $created_at
    ) {
        parent::__construct($updated_at, $created_at);
        $this->id = $id;
        $this->category = $category;
        $this->description = $description;
        $this->due_date = $due_date;
        $this->checked = $checked;
        $this->position = $position;
        $this->last_editor = $last_editor;
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

}
