<?php

namespace App\Money;

interface MathInterface
{
    public function multiply(MoneyInterface $money, int|float|string $multiplier): MoneyInterface;

    public function add(MoneyInterface ...$addends): MoneyInterface;
}