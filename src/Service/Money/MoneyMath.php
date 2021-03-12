<?php

namespace App\Service\Money;

use App\Money\MathInterface;
use App\Money\MoneyInterface;
use Money\Money;

class MoneyMath implements MathInterface
{
    public function __construct(private MoneyTransformer $transformer)
    {
    }

    public function multiply(MoneyInterface $money, int | float | string $multiplier): MoneyInterface
    {
        return $this->transformer->reverseTransform(
            $this->transformer->transform($money)->multiply($multiplier)
        );
    }

    public function add(MoneyInterface ...$addends): MoneyInterface
    {
        $addends = array_map(
            fn (MoneyInterface $addend) => $this->transformer->transform($addend),
            $addends
        );

        /** @var Money $money */
        $money = array_shift($addends);

        return $this->transformer->reverseTransform($money->add(...$addends));
    }
}
