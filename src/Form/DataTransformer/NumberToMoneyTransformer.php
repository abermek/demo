<?php

namespace App\Form\DataTransformer;

use Exception;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Money\Money;

class NumberToMoneyTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        /** @var Money $value */
        if (null === $value) {
            return null;
        }

        return $value->getAmount();
    }

    public function reverseTransform($value): ?Money
    {
        if (null === $value) {
            return null;
        }

        try {
            $money = Money::USD($value);
        } catch (Exception $e) {
            $privateErrorMessage = $e->getMessage();
            $publicErrorMessage = 'The given "{{ value }}" value is not valid.';

            $failure = new TransformationFailedException($privateErrorMessage);
            $failure->setInvalidMessage(
                $publicErrorMessage,
                [
                    '{{ value }}' => $value,
                ]
            );

            throw $failure;
        }

        return $money;
    }
}
