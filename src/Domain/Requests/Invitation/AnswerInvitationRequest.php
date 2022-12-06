<?php

namespace App\Domain\Requests\Invitation;

class AnswerInvitationRequest
{

    private int $userId;
    private int $invitationId;
    private array $formData;

    /**
     * @param int $userId
     * @param int $invitationId
     * @param array $formData
     */
    public function __construct(int $userId, int $invitationId, array $formData)
    {
        $this->userId = $userId;
        $this->invitationId = $invitationId;
        $this->formData = $formData;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
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
    public function getInvitationId(): int
    {
        return $this->invitationId;
    }

}