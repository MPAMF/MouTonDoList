<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;

abstract class Repository
{

    private DatabaseManager $db;
    private string $tableName;

    public function __construct(DatabaseManager $db, string $tableName = null)
    {
        $this->db = $db;
        $this->tableName = $tableName;
    }

    public function getDB(): DatabaseManager
    {
        return $this->db;
    }

    public function getTable() : Builder
    {
        return $this->getDB()->table($this->tableName);
    }

}