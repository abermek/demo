<?php

namespace App\Validator\Money;

use Symfony\Component\Validator\Constraint;

class GreaterThan extends Constraint
{
    public string $message = 'This value should be greater than {{ value }}.';
    public float $value = 0.0;

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
