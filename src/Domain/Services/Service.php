<?php

namespace App\Domain\Services;

use Symfony\Component\Translation\Translator;
use Tagliatti\SlimValidation\ValidatorInterface;

abstract class Service
{

    protected ValidatorInterface $validator;
    protected Translator $translator;

    /**
     * @param ValidatorInterface $validator
     * @param Translator $translator
     */
    public function __construct(ValidatorInterface $validator, Translator $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }
}
