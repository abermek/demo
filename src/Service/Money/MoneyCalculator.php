<?php

namespace App\Service\Money;

use App\Money\MoneyInterface;
use Money\Currency;
use Money\Money;
use App\Money\Money as MyMoney;

class MoneyCalculator
{
    private MoneyTransformer $transformer;

    public function __construct(MoneyTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /** @var int|float|string $multiplier */
    public function multiply(MoneyInterface $money, $multiplier): MoneyInterface
    {
        return $this->transformer->reverseTransform(
            $this->transformer->transform($money)->multiply($multiplier)
        );
    }

    public function add(MoneyInterface ...$addends): MoneyInterface
    {
        $addends = array_map(
            fn(MoneyInterface $addend) => $this->transformer->transform($addend),
            $addends
        );

        $money = array_shift($addends);

        return $this->transformer->reverseTransform($money->add(... $addends));
    }
}