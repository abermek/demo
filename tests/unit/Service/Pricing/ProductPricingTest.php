<?php

namespace Tests\Unit\Service\Pricing;

use App\Entity\Product;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyMath;
use App\Service\Pricing\ProductPricing;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductPricingTest extends Unit
{
    private MoneyMath | MockInterface $math;

    protected function _before()
    {
        $this->math = Mockery::mock(MoneyMath::class);
    }

    public function getSystemUnderTest(): ProductPricing
    {
        return new ProductPricing($this->math);
    }

    public function testCalculateCartItemTotal()
    {
        $product = Mockery::mock(Product::class);
        $price = Mockery::mock(MoneyInterface::class);
        $total = Mockery::mock(MoneyInterface::class);

        $quantity = 3;
        $name = 'sword';

        $product
            ->shouldReceive('getPrice')
            ->andReturn($price);

        $product
            ->shouldReceive('getName')
            ->andReturn($name);

        $this->math
            ->shouldReceive('multiply')
            ->with($price, $quantity)
            ->andReturn($total);

        $result = $this->getSystemUnderTest()->execute($product, $quantity);

        self::assertEquals($total, $result->total);

    }
}
