<?php

namespace App\Validator\Money;

use Money\Money;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class GreaterThanValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }

        if (!$value instanceof Money) {
            throw new UnexpectedTypeException($value, Money::class);
        }

        if (!$constraint instanceof GreaterThan) {
            throw new UnexpectedTypeException($constraint, GreaterThan::class);
        }

        if ($value->getAmount() <= $constraint->value) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->getAmount())
                ->addViolation();
        }
    }
}
