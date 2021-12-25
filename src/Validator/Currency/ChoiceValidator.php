<?php

namespace App\Validator\Currency;

use Money\Money;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\ChoiceValidator as BaseValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ChoiceValidator extends BaseValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }

        if (!$value instanceof Money) {
            throw new UnexpectedTypeException($value, Money::class);
        }

        parent::validate($value->getCurrency()->getCode(), $constraint);
    }
}
