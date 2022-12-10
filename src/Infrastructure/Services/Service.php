<?php

namespace App\Infrastructure\Services;

use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\ValidatorInterface;

abstract class Service
{

    protected ValidatorInterface $validator;
    protected TranslatorInterface $translator;

    /**
     * @param ValidatorInterface $validator
     * @param TranslatorInterface $translator
     */
    public function __construct(ValidatorInterface $validator, TranslatorInterface $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }
}
