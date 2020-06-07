<?php

namespace Tests\Unit\Service\Pricing\Cart\Strategy;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyCalculator;
use App\Service\Pricing\Cart\Strategy\CartItemStrategy;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CartItemStrategyTest extends Unit
{
    /** @var MoneyCalculator | MockInterface */
    private $calculator;

    protected function _before()
    {
        $this->calculator = Mockery::mock(MoneyCalculator::class);
    }

    public function getSystemUnderTest(): CartItemStrategy
    {
        return new CartItemStrategy($this->calculator);
    }

    public function testCalculateCartItemTotal()
    {
        /** @var CartItem | MockInterface $sword */
        $sword  = Mockery::mock(CartItem::class);
        /** @var Product | MockInterface $product */
        $product = Mockery::mock(Product::class);
        /** @var MoneyInterface|MockObject $price */
        $price = Mockery::mock(MoneyInterface::class);
        /** @var MoneyInterface|MockObject $total */
        $total = Mockery::mock(MoneyInterface::class);

        $quantity = 3;

        $sword
            ->shouldReceive('getProduct')
            ->andReturn($product);

        $product
            ->shouldReceive('getPrice')
            ->andReturn($price);

        $sword
            ->shouldReceive('getQuantity')
            ->andReturn($quantity);

        $this->calculator
            ->shouldReceive('multiply')
            ->with($price, $quantity)
            ->andReturn($total);

        $result = $this->getSystemUnderTest()->execute($sword);

        self::assertEquals($total, $result);

    }
}