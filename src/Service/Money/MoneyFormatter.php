<?php

namespace App\Service\Money;

use App\Money\MoneyInterface;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;

class MoneyFormatter
{
    private IntlMoneyFormatter $formatter;

    public function __construct(string $locale, private MoneyTransformer $transformer)
    {
        $this->formatter = new IntlMoneyFormatter(
            new NumberFormatter($locale, NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
    }

    public function format(MoneyInterface $money): string
    {
        return $this->formatter->format(
            $this->transformer->transform($money)
        );
    }
}
