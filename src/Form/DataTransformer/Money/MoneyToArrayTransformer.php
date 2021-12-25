<?php

namespace App\Form\DataTransformer\Money;

use App\Service\Money\Parser;
use InvalidArgumentException;
use Money\Currency;
use Money\Exception\ParserException;
use Money\Exception\UnknownCurrencyException;
use Money\Money;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MoneyToArrayTransformer implements DataTransformerInterface
{
    public function __construct(private Parser $parser)
    {
    }

    public function transform($value): ?array
    {
        /** @var Money $value */
        if (is_null($value)) {
            return null;
        }

        return [
            'amount' => $value->getAmount(),
            'currency' => $value->getCurrency()
        ];
    }

    public function reverseTransform($value): ?Money
    {
        if ($value['amount'] === null && $value['currency'] === null) {
            return null;
        }

        try {
            return $this->parser->decimal($value['amount'], new Currency($value['currency']));
        } catch (InvalidArgumentException|ParserException|UnknownCurrencyException $e) {
            $failure = new TransformationFailedException($e->getMessage());
            $failure->setInvalidMessage('This value is not a valid money');

            throw $failure;
        }
    }
}
