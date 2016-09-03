<?php

namespace ApiBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use VulgarDetectorBundle\Repository\WordRepository;

class LanguageValidator extends ConstraintValidator
{
    private $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (isset($value)) {
            $language = $this->wordRepository->findBy(['language' => $value]);
            if (empty($language)) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
