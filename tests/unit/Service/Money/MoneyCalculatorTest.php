<?php

namespace App\Tests\Service\Money;

use App\Money\MoneyInterface;
use App\Service\Money\MoneyCalculator;
use App\Service\Money\MoneyTransformer;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Money\Money;

class MoneyCalculatorTest extends Unit
{
    /** @var MoneyTransformer | MockInterface  */
    private $transformer;

    protected function _before()
    {
        $this->transformer = Mockery::mock(MoneyTransformer::class);
    }

    public function getSystemUnderTest(): MoneyCalculator
    {
        return new MoneyCalculator($this->transformer);
    }

    public function testMultiply()
    {
        /** @var MoneyInterface|MockInterface $appMoney */
        $appMoney   = Mockery::mock(MoneyInterface::class);
        $multiplier = 2;
        $amount     = 200;
        $money      = Money::USD($amount);

        $this->transformer
            ->shouldReceive('transform')
            ->with($appMoney)
            ->andReturn($money);

        $matcher = function ($money) use ($amount, $multiplier) {
            return $money instanceof Money
                && $money->getAmount() == $amount * $multiplier;
        };

        $this->transformer
            ->shouldReceive('reverseTransform')
            ->with(Mockery::on($matcher))
            ->andReturn($appMoney);

        self::assertEquals($appMoney, $this->getSystemUnderTest()->multiply($appMoney, $multiplier));
    }

    public function testAdd()
    {
        /** @var MoneyInterface|MockInterface $money1 */
        $money1   = Mockery::mock(MoneyInterface::class);
        /** @var MoneyInterface|MockInterface $money2 */
        $money2   = Mockery::mock(MoneyInterface::class);
        /** @var MoneyInterface|MockInterface $return */
        $return   = Mockery::mock(MoneyInterface::class);

        $amount = 200;
        $addend1 = Money::USD($amount);
        $addend2 = Money::USD($amount);

        $this->transformer
            ->shouldReceive('transform')
            ->with($money1)
            ->andReturn($addend1);

        $this->transformer
            ->shouldReceive('transform')
            ->with($money2)
            ->andReturn($addend2);

        $matcher = function ($money) use ($amount) {
            return $money instanceof Money
                && $money->getAmount() == $amount * 2;
        };

        $this->transformer
            ->shouldReceive('reverseTransform')
            ->with(Mockery::on($matcher))
            ->andReturn($return);

        self::assertEquals($return, $this->getSystemUnderTest()->add($money1, $money2));
    }
}
