<?php

namespace App\Domain\Exceptions;

use Exception;

class BadRequestException extends Exception
{

    public function __construct(string $message = "")
    {
        parent::__construct($message);
    }

}