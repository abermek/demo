<?php

namespace Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Service\Cart\FindOrCreateCartByCustomer;
use App\Service\Repository\CartRepositoryInterface;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;
use Mockery\MockInterface;

class GetCustomerCartTest extends Unit
{
    /** @var EntityManagerInterface|MockInterface */
    private EntityManagerInterface $em;

    protected function _before()
    {
        $this->em = Mockery::mock(EntityManagerInterface::class);
    }

    public function getSystemUnderTest(): FindOrCreateCartByCustomer
    {
        return new FindOrCreateCartByCustomer($this->em);
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

        $this->em->shouldNotReceive('persist');

        self::assertEquals($cart, $this->getSystemUnderTest()->execute($customer));
    }

    public function testCustomerDoesNotHaveACart()
    {
        /** @var User|MockInterface $customer */
        $customer = Mockery::mock(User::class);

        $customer
            ->shouldReceive('getCart')
            ->andReturn(null);

        $this->em->shouldReceive('persist');

        $cart = $this->getSystemUnderTest()->execute($customer);

        self::assertTrue($cart instanceof Cart);
    }
}
