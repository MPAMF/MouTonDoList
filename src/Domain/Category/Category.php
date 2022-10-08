<?php

namespace App\Domain\Category;

use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;

class Category extends TimeStampedModel implements JsonSerializable
{

    private ?int $id;
    private User $owner;
    private ?Category $parentCategory;
    private string $name;
    private string $color;
    private int $position;
    private bool $archived;

    /**
     * @param int|null $id
     * @param User $owner
     * @param Category|null $parentCategory
     * @param string $name
     * @param string $color
     * @param int $position
     * @param bool $archived
     */
    public function __construct(
        ?int $id,
        User $owner,
        ?Category $parentCategory,
        string $name,
        string $color,
        int $position,
        bool $archived,
        DateTime $updated_at,
        DateTime $created_at
    ) {
        parent::__construct($updated_at, $created_at);
        $this->id = $id;
        $this->owner = $owner;
        $this->parentCategory = $parentCategory;
        $this->name = $name;
        $this->color = $color;
        $this->position = $position;
        $this->archived = $archived;
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
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
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


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->owner->getId(),
            'parent_category_id' => isset($this->parentCategory) ? $this->parentCategory->getId() : '',
            'name' => $this->name,
            'color' => $this->color,
            'position' => $this->position,
            'archived' => $this->archived
        ];
    }
}
