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
     * @return mixed
     */
    public function fromValidator(array|object $data): mixed;

}