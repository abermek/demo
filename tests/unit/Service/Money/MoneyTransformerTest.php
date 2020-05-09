<?php

namespace App\Tests\Service\Money;

use App\Money\MoneyInterface;
use App\Service\Money\MoneyTransformer;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Money\Currency;
use Money\Money;

class MoneyTransformerTest extends Unit
{
    public function getSystemUnderTest(): MoneyTransformer
    {
        return new MoneyTransformer();
    }

    public function testTransform()
    {
        /** @var MoneyInterface|MockInterface $money */
        $money      = Mockery::mock(MoneyInterface::class);
        $amount     = "100";
        $currency   = 'USD';

        $money
            ->shouldReceive('getAmount')
            ->andReturn($amount);

        $money
            ->shouldReceive('getCurrency')
            ->andReturn($currency);

        $output = $this->getSystemUnderTest()->transform($money);

        self::assertTrue($output instanceof Money);
        self::assertEquals($amount, $output->getAmount());
        self::assertEquals($currency, $output->getCurrency()->getCode());
    }

    public function testReverseTransform()
    {
        $amount     = "100";
        $currency   = 'USD';
        $money      = new Money($amount, new Currency($currency));

        $output = $this->getSystemUnderTest()->reverseTransform($money);

        self::assertTrue($output instanceof MoneyInterface);
        self::assertEquals($amount, $output->getAmount());
        self::assertEquals($currency, $output->getCurrency());
    }
}
