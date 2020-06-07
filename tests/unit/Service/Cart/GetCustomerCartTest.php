<?php

namespace Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Service\Cart\GetCustomerCart;
use App\Service\Repository\CartRepositoryInterface;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;

class GetCustomerCartTest extends Unit
{
    /** @var CartRepositoryInterface|MockInterface */
    private CartRepositoryInterface $repository;

    protected function _before()
    {
        $this->repository = Mockery::mock(CartRepositoryInterface::class);
    }

    public function getSystemUnderTest(): GetCustomerCart
    {
        return new GetCustomerCart($this->repository);
    }

    public function testCustomerAlreadyHaveACart()
    {
        /** @var User|MockInterface $customer */
        $customer = Mockery::mock(User::class);
        /** @var Cart|MockInterface $cart */
        $cart = Mockery::mock(Cart::class);

        $customer
            ->shouldReceive('getCart')
            ->andReturn($cart);

        $this->repository->shouldNotReceive('create');

        self::assertEquals($cart, $this->getSystemUnderTest()->execute($customer));
    }

    public function testCustomerDoesNotHaveACart()
    {
        /** @var User|MockInterface $customer */
        $customer = Mockery::mock(User::class);

        $customer
            ->shouldReceive('getCart')
            ->andReturn(null);

        $this->repository->shouldReceive('create');

        $cart = $this->getSystemUnderTest()->execute($customer);

        self::assertTrue($cart instanceof Cart);
    }
}
