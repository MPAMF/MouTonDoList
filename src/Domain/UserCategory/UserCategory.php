<?php
declare(strict_types=1);

namespace App\Domain\UserCategory;

use App\Domain\Category\Category;
use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;
use stdClass;

class UserCategory extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;
    private int $user_id;
    private ?User $user;
    private int $category_id;
    private ?Category $category;
    private bool $accepted;
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

    #[\ReturnTypeWillChange]
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
        ];

        if(isset($this->members)) {
            $result['members'] = $this->members;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->user_id = $row->user_id;
        $this->user = $row->user;
        $this->category_id = $row->category_id;
        $this->category = $row->category;
        $this->accepted = boolval($row->accepted);
        $this->canEdit = boolval($row->can_edit);
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
        return $result;
    }
}
