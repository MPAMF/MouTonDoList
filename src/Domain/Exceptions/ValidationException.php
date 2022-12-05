<?php

namespace App\Domain\Exceptions;

use Exception;

class ValidationException extends Exception
{

    private array $errors;

    public function __construct(array $errors)
    {
        parent::__construct("Validation error occurred");
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