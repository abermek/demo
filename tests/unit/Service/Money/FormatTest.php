<?php

namespace Tests\Unit\Service\Money;

use App\Service\Money\Format;
use Codeception\Test\Unit;
use Money\Currency;
use Money\Money;

class FormatTest extends Unit
{
    public function getSystemUnderTest(string $locale): Format
    {
        return new Format($locale);
    }

    /** @dataProvider dataProviderForFormat */
    public function testFormat(string $locale, int $amount, string $currency, string $expectedResult)
    {
        $output = $this->getSystemUnderTest($locale)->execute(new Money($amount, new Currency($currency)));

        self::assertEquals($output, $expectedResult);
    }

    public function dataProviderForFormat(): array
    {
        return [
            ['en', 1000, 'USD', '$10.00'],
            ['en', 1099, 'USD', '$10.99'],
        ];
    }
}
