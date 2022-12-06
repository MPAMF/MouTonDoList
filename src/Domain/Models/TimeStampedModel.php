<?php
declare(strict_types=1);

namespace App\Domain\Models;

use DateTime;
use stdClass;

class TimeStampedModel implements EloquentModel
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

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        if (!empty($row->updated_at)) {
            $this->setUpdatedAt(new DateTime($row->updated_at));
        }

        if (!empty($row->created_at)) {
            $this->setCreatedAt(new DateTime($row->created_at));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        // Do nothing: tables are auto updated
        return [];
    }
}
