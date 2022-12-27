<?php

namespace App\Domain\Models;

use Exception;
use stdClass;

interface EloquentModel
{
    /**
     * @param stdClass $row
     * @throws Exception
     */
    public function fromRow(stdClass $row): void;

    /**
     * @return array
     */
    public function toRow(): array;
}
