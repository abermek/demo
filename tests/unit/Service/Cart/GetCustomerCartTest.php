<?php

namespace Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Service\Cart\GetCustomerCart;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;
use Mockery\MockInterface;

class GetCustomerCartTest extends Unit
{
    public function getSystemUnderTest(): GetCustomerCart
    {
        return new GetCustomerCart();
    }

    public function testCustomerAlreadyHaveACart()
    {
        $customer = Mockery::mock(User::class);
        $cart = Mockery::mock(Cart::class);

        $customer
            ->shouldReceive('getCart')
            ->andReturn($cart);

        self::assertEquals($cart, $this->getSystemUnderTest()->execute($customer));
    }

    public function testCustomerDoesNotHaveACart()
    {
        $customer = Mockery::mock(User::class);

        $customer
            ->shouldReceive('getCart')
            ->andReturn(null);

        $cart = $this->getSystemUnderTest()->execute($customer);

        self::assertTrue($cart instanceof Cart);
    }
}
