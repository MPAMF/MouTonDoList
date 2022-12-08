<?php

namespace App\Domain\Exceptions;

use Exception;

class NoPermissionException extends Exception
{

    public function __construct(string $message = "")
    {
        parent::__construct($message);
    }

}