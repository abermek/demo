<?php

namespace App\Service\Money;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;
use Money\Money;

class Format
{
    private IntlMoneyFormatter $formatter;

    public function __construct(string $locale)
    {
        $this->formatter = new IntlMoneyFormatter(
            new NumberFormatter($locale, NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
    }

    public function execute(Money $money): string
    {
        return $this->formatter->format($money);
    }
}
