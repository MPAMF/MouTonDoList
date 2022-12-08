<?php

namespace App\Domain\Requests\Invitation;

class DeleteInvitationRequest
{

    private int $userId;
    private int $invitationId;

    /**
     * @param int $userId
     * @param int $invitationId
     */
    public function __construct(int $userId, int $invitationId)
    {
        $this->userId = $userId;
        $this->invitationId = $invitationId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getInvitationId(): int
    {
        return $this->invitationId;
    }
}
