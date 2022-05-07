<?php

namespace Tests\Unit\Service\Money;

use App\Service\Money\Formatter;
use Codeception\Test\Unit;
use Money\Currency;
use Money\Money;

class FormatterTest extends Unit
{
    public function getSystemUnderTest(string $locale): Formatter
    {
        return new Formatter($locale);
    }

    /** @dataProvider dataProviderForFormatMoney */
    public function testFormatMoney(string $locale, int $amount, string $currency, string $expectedResult)
    {
        $output = $this->getSystemUnderTest($locale)->money(new Money($amount, new Currency($currency)));

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
