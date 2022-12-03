<?php

namespace App\Domain;

interface ValidatorModel
{

    public static function getValidatorRules(): array;

    public function fromValidator(array $data);

}