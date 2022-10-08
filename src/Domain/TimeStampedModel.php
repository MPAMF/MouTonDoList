<?php

namespace App\Domain;

use DateTime;

class TimeStampedModel
{
    private DateTime $updated_at;

    private DateTime $created_at;

    /**
     * @param DateTime $updated_at
     * @param DateTime $created_at
     */
    public function __construct(DateTime $updated_at, DateTime $created_at)
    {
        $this->updated_at = $updated_at;
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }


}