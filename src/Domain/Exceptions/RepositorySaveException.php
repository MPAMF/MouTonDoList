<?php

namespace App\Domain\Exceptions;

use Exception;

class RepositorySaveException extends Exception
{

    public function __construct(string $message = "")
    {
        parent::__construct($message);
    }

}