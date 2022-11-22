<?php

namespace App\Infrastructure\Repositories;

use DI\Annotation\Inject;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;

abstract class Repository
{

    /**
     * @Inject
     * @var DatabaseManager
     */
    private DatabaseManager $db;
    protected string $tableName;

    public function __construct(string $tableName)
    {
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