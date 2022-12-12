<?php

namespace App\Domain\Requests\User;

class CreateUserRequest
{

    private array $formData;

    /**
     * @param array $formData
     */
    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }
}
