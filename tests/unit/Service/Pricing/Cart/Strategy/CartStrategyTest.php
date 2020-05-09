<?php

namespace unit\Service\Pricing\Cart\Strategy;

use App\Cart\CartInterface;
use App\Entity\CartItem;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyCalculator;
use App\Service\Pricing\Cart\Strategy\CartItemStrategyInterface;
use App\Service\Pricing\Cart\Strategy\CartStrategy;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;

class CartStrategyTest extends Unit
{
    /** @var CartItemStrategyInterface | MockInterface  */
    private $itemStrategy;
    /** @var MoneyCalculator | MockInterface */
    private $calculator;

    protected function _before()
    {
        $this->itemStrategy = Mockery::mock(CartItemStrategyInterface::class);
        $this->calculator = Mockery::mock(MoneyCalculator::class);
    }

    public function getSystemUnderTest(): CartStrategy
    {
        return new CartStrategy($this->itemStrategy, $this->calculator);
    }

    public function testCalculateCartTotal()
    {
        /** @var CartInterface|MockInterface $cart */
        $cart   = Mockery::mock(CartInterface::class);
        /** @var CartItem | MockInterface $sword */
        $sword  = Mockery::mock(CartItem::class);
        /** @var CartItem | MockInterface $shield */
        $shield = Mockery::mock(CartItem::class);
        /** @var MoneyInterface|MockInterface $swordTotal */
        $swordTotal = Mockery::mock(MoneyInterface::class);
        /** @var MoneyInterface|MockInterface $shieldTotal */
        $shieldTotal = Mockery::mock(MoneyInterface::class);

        $cart
            ->shouldReceive('getItems')
            ->andReturn([$sword, $shield]);

        $this->itemStrategy
            ->shouldReceive('execute')
            ->with($sword)
            ->andReturn($swordTotal);

        $this->itemStrategy
            ->shouldReceive('execute')
            ->with($shield)
            ->andReturn($shieldTotal);

        $this->calculator
            ->shouldReceive('add')
            ->with($swordTotal, $shieldTotal)
            ->andReturn($shieldTotal);

        $result = $this->getSystemUnderTest()->execute($cart);

        self::assertEquals($shieldTotal, $result);
    }
}