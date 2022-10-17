<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\DatabaseManager;

class Repository
{

    private DatabaseManager $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function getDB(): DatabaseManager
    {
        return $this->db;
    }

}