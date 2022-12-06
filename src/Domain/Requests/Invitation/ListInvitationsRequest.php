<?php

namespace App\Domain\Requests\Invitation;

class ListInvitationsRequest
{

    private int $userId;
    private array $formData;

    /**
     * @param int $userId
     * @param array $formData
     */
    public function __construct(int $userId, array $formData)
    {
        $this->userId = $userId;
        $this->formData = $formData;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

}