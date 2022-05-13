<?php

namespace App\Tests\Service\Money;

use App\Service\Money\Formatter;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    /** @dataProvider dataProviderForFormatMoney */
    public function testMoney(string $locale, int $amount, string $currency, string $expectedResult)
    {
        $output = (new Formatter($locale))->money(new Money($amount, new Currency($currency)));

        self::assertEquals($output, $expectedResult);
    }

    public function dataProviderForFormatMoney(): array
    {
        return [
            ['en', 1000, 'USD', '$10.00'],
            ['en', 1099, 'USD', '$10.99'],
        ];
    }
}
