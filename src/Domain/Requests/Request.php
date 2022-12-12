<?php

namespace App\Domain\Requests;

interface Request
{

    /**
     * @return array|null
     */
    public function getData(): ?array;

}