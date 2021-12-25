<?php

namespace App\Service\Money;

use Money\Currencies;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

final class Formatter
{
    public function __construct(private string $locale, private Currencies $currencies = new ISOCurrencies())
    {
    }

    public function decimal(Money $money): string
    {
        return (new DecimalMoneyFormatter($this->currencies))->format($money);
    }

    public function money(Money $money, int $style = NumberFormatter::CURRENCY): string
    {
        return  (new IntlMoneyFormatter(new NumberFormatter($this->locale, $style), $this->currencies))->format($money);
    }
}
