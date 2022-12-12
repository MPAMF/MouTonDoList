<?php

namespace App\Domain\Exceptions;

use Exception;

class BadRequestException extends Exception
{

    private array $errors;

    public function __construct(string $message = "", array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}