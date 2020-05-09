<?php

namespace App\Service\Money;

use App\Money\Money as AppMoney;
use App\Money\MoneyInterface;
use Money\Currency;
use Money\Money;

class MoneyTransformer
{
    public function transform(MoneyInterface $money): Money
    {
        return new Money(
            $money->getAmount(),
            new Currency($money->getCurrency())
        );
    }

    public function reverseTransform(Money $money): MoneyInterface
    {
        return new AppMoney(
            $money->getAmount(),
            $money->getCurrency()->getCode()
        );
    }
}
