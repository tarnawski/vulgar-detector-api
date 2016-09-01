<?php

namespace ApiBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Language extends Constraint
{
    public $message = 'Language not exist';

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
    public function validatedBy()
    {
        return 'language_validate';
    }
}