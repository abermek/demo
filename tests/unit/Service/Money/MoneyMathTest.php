<?php

namespace Tests\Unit\Service\Money;

use App\Money\MoneyInterface;
use App\Service\Money\MoneyMath;
use App\Service\Money\MoneyTransformer;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Money\Money;

class MoneyMathTest extends Unit
{
    private MoneyTransformer | MockInterface  $transformer;

    protected function _before()
    {
        $this->transformer = Mockery::mock(MoneyTransformer::class);
    }

    public function getSystemUnderTest(): MoneyMath
    {
        return new MoneyMath($this->transformer);
    }

    public function testMultiply()
    {
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
        $money1   = Mockery::mock(MoneyInterface::class);
        $money2   = Mockery::mock(MoneyInterface::class);
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
