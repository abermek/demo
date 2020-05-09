<?php

namespace App\Tests\Service\Money;

use App\Money\MoneyInterface;
use App\Service\Money\MoneyFormatter;
use App\Service\Money\MoneyTransformer;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Money\Currency;
use Money\Money;

class MoneyFormatterTest extends Unit
{
    /** @var MoneyTransformer|MockInterface */
    private $transformer;

    protected function _before()
    {
        $this->transformer = Mockery::mock(MoneyTransformer::class);
    }

    public function getSystemUnderTest(string $locale): MoneyFormatter
    {
        return new MoneyFormatter($locale, $this->transformer);
    }

    /** @dataProvider dataProviderForFormat */
    public function testFormat(string $locale, int $amount, string $currency,  string $expectedResult)
    {
        /** @var MoneyInterface|MockInterface $money */
        $money = Mockery::mock(MoneyInterface::class);

        $this->transformer
            ->shouldReceive('transform')
            ->with($money)
            ->andReturn(new Money($amount, new Currency($currency)));

        $output = $this->getSystemUnderTest($locale)->format($money);

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
