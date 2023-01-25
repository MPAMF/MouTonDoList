<?php

namespace App\Domain\Requests\Task;

class SearchTaskRequest
{
    private int $userId;
    private ?array $with;
    private ?string $searchInput;

    /**
     * @param int $userId
     * @param string $searchInput
     * @param array|null $with
     */
    public function __construct(int $userId, string $searchInput, array|null $with = null)
    {
        $this->userId = $userId;
        $this->with = $with;
        $this->searchInput = $searchInput;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return array|null
     */
    public function getWith(): ?array
    {
        return $this->with;
    }

    /**
     * @return string|null
     */
    public function getSearchInput(): ?string
    {
        return $this->searchInput;
    }

}
