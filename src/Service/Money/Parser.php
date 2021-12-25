<?php

namespace App\Service\Money;

use Money\Currencies;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

final class Parser
{
    public function __construct(private Currencies $currencies = new ISOCurrencies())
    {
    }

    public function decimal(string|float $money, Currency $currency): Money
    {
        return (new DecimalMoneyParser($this->currencies))->parse((string) $money, $currency);
    }
}
