<?php

namespace App\Tests\Service\ParamConverter;

use App\Cart\CartInterface;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Security\User;
use App\Exception\Cart\EmptyCartException;
use App\Money\MoneyInterface;
use App\Service\Cart\CreateInvoice;
use App\Service\Pricing\Cart\Strategy\CartItemStrategyInterface;
use App\Service\Pricing\Cart\Strategy\CartStrategyInterface;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;

class CreateInvoiceTest extends Unit
{
    /** @var CartStrategyInterface|MockInterface */
    private $cartStrategy;
    /** @var CartItemStrategyInterface|MockInterface */
    private $cartItemStrategy;

    protected function _before()
    {
        $this->cartStrategy = Mockery::mock(CartStrategyInterface::class);
        $this->cartItemStrategy = Mockery::mock(CartItemStrategyInterface::class);
    }

    public function getSystemUnderTest(): CreateInvoice
    {
        return new CreateInvoice($this->cartStrategy, $this->cartItemStrategy);
    }

    public function testItCreatesInvoiceFromCart()
    {
        /** @var CartInterface|MockInterface $cart */
        $cart = Mockery::mock(CartInterface::class);
        /** @var CartItem|MockInterface $shield */
        $shield  = Mockery::mock(CartItem::class);
        /** @var CartItem|MockInterface $sword */
        $sword  = Mockery::mock(CartItem::class);
        /** @var User|MockInterface $customer */
        $customer  = Mockery::mock(User::class);
        /** @var MoneyInterface|MockInterface $total */
        $total = Mockery::mock(MoneyInterface::class);

        $cart
            ->shouldReceive('isEmpty')
            ->andReturn(false);

        $cart
            ->shouldReceive('getItems')
            ->andReturn([$sword, $shield]);

        $shield
            ->shouldReceive('getProduct')
            ->andReturn(Mockery::mock(Product::class));

        $shield
            ->shouldReceive('getQuantity')
            ->andReturn(1);

        $this->cartItemStrategy
            ->shouldReceive('execute')
            ->with($shield)
            ->andReturn(Mockery::mock(MoneyInterface::class));

        $sword
            ->shouldReceive('getProduct')
            ->andReturn(Mockery::mock(Product::class));

        $sword
            ->shouldReceive('getQuantity')
            ->andReturn(1);

        $this->cartItemStrategy
            ->shouldReceive('execute')
            ->with($sword)
            ->andReturn(Mockery::mock(MoneyInterface::class));

        $cart
            ->shouldReceive('getCustomer')
            ->andReturn($customer);

        $this->cartStrategy
            ->shouldReceive('execute')
            ->with($cart)
            ->andReturn($total);

        $invoice = $this->getSystemUnderTest()->execute($cart);

        self::assertEquals($customer, $invoice->getCustomer());
        self::assertEquals($total, $invoice->getTotal());
        self::assertEquals(2, count($invoice->getItems()));
    }

    public function testItThrowsAnExceptionIfCartIsEmpty()
    {
        /** @var CartInterface|MockInterface $cart */
        $cart = Mockery::mock(CartInterface::class);

        $cart
            ->shouldReceive('isEmpty')
            ->andReturn(true);

        $this->expectException(EmptyCartException::class);

        $this->getSystemUnderTest()->execute($cart);
    }
}
