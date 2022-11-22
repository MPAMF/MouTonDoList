<?php

namespace App\Infrastructure\Lib;

use App\Domain\DbCacheInterface;

class DbCacheImpl implements DbCacheInterface
{

    private array $cache = [];

    public function load(string $modelName, int $id): mixed
    {
        return $this->cache[$modelName][$id] ?? null;
    }

    public function save(string $modelName, int $id, mixed $model): void
    {
        $this->cache[$modelName][$id] = $model;
    }

}