<?php

namespace App\Domain;

interface DbCacheInterface
{

    /**
     * @param string $modelName
     * @param int $id
     * @return mixed
     */
    public function load(string $modelName, int $id): mixed;

    /**
     * @param string $modelName
     * @param int $id
     * @param mixed $model
     * @return void
     */
    public function save(string $modelName, int $id, mixed $model): void;

}