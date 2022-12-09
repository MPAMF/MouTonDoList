<?php

namespace App\Domain\Requests\Invitation;

class GetInvitationRequest
{
    private int $userId;
    private int $invitationId;
    private ?array $with;

    /**
     * @param int $userId
     * @param int $invitationId
     * @param array|null $with
     */
    public function __construct(int $userId, int $invitationId, array|null $with = null)
    {
        $this->userId = $userId;
        $this->invitationId = $invitationId;
        $this->with = $with;
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

    /**
     * @return array|null
     */
    public function getWith(): ?array
    {
        return $this->with;
    }
}
