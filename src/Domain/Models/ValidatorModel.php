<?php

namespace App\Domain\Models;

interface ValidatorModel
{

    /**
     * @return array
     */
    public static function getValidatorRules(): array;

    /**
     * @param array|object $data
     * @return void
     */
    public function fromValidator(array|object $data): void;
}
