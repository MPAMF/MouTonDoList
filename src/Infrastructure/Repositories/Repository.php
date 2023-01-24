<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;

abstract class Repository
{

    protected string $tableName;
    /**
     * @Inject
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function getTable(): Builder
    {
        return $this->getDB()->table($this->tableName);
    }

    public function getDB(): DatabaseManager
    {
        return $this->db;
    }

}