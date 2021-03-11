<?php

namespace Tests\Unit\Service\Pricing;

use App\Money\MoneyInterface;
use App\Pricing\PurchaseInterface;
use App\Service\Money\MoneyMath;
use App\Service\Pricing\PricingStrategy;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;

class PricingStrategyTest extends Unit
{
    private MoneyMath | MockInterface $math;

    protected function _before()
    {
        $this->math = Mockery::mock(MoneyMath::class);
    }

    public function getSystemUnderTest(): PricingStrategy
    {
        return new PricingStrategy($this->math);
    }

    public function testCalculateCartItemTotal()
    {
        $purchase = Mockery::mock(PurchaseInterface::class);
        $price = Mockery::mock(MoneyInterface::class);
        $total = Mockery::mock(MoneyInterface::class);

        $quantity = 3;
        $name = 'sword';

        $purchase
            ->shouldReceive('getProductPrice')
            ->andReturn($price);

        $purchase
            ->shouldReceive('getProductName')
            ->andReturn($name);

        $purchase
            ->shouldReceive('getProductId')
            ->andReturn(1);

        $purchase
            ->shouldReceive('getProductQuantity')
            ->andReturn($quantity);

        $this->math
            ->shouldReceive('multiply')
            ->with($price, $quantity)
            ->andReturn($total);

        $result = $this->getSystemUnderTest()->execute($purchase);

        self::assertEquals($total, $result->getGrandTotal());

    }
}
