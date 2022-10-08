<?php

namespace App\Domain\Category;

use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;

class UserCategory extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;
    private User $user;
    private Category $category;
    private bool $accepted;
    private bool $can_edit;

    /**
     * @param int|null $id
     * @param User $user
     * @param Category $category
     * @param bool $accepted
     * @param bool $can_edit
     */
    public function __construct(
        ?int $id,
        User $user,
        Category $category,
        bool $accepted,
        bool $can_edit,
        DateTime $updated_at,
        DateTime $created_at
    ) {
        parent::__construct($updated_at, $created_at);
        $this->id = $id;
        $this->user = $user;
        $this->category = $category;
        $this->accepted = $accepted;
        $this->can_edit = $can_edit;
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
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
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
        return $this->can_edit;
    }

    /**
     * @param bool $can_edit
     */
    public function setCanEdit(bool $can_edit): void
    {
        $this->can_edit = $can_edit;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->getId(),
            'category_id' => $this->category->getId(),
            'accepted' => $this->accepted,
            'can_edit' => $this->can_edit,
        ];
    }
}
