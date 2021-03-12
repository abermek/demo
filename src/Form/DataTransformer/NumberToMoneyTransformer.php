<?php

namespace App\Form\DataTransformer;

use App\Money\MoneyInterface;
use App\Model\Money\USD;
use Exception;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class NumberToMoneyTransformer implements DataTransformerInterface
{
    public function transform($money)
    {
        /** @var MoneyInterface $money */
        if (null === $money) {
            return null;
        }

        return $money->getAmount();
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }

        try {
            $money = new USD($value);
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