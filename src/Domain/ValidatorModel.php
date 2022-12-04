<?php

namespace App\Domain;

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
    public function fromValidator(array|object $data);

}