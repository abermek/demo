<?php

namespace  Tests\Unit\Service\ParamConverter;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Service\Cart\FindOrCreateCartByCustomer;
use App\Service\ParamConverter\CartConverter;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CartConverterTest extends Unit
{
    /** @var Security|MockInterface */
    private $security;
    /** @var FindOrCreateCartByCustomer|MockInterface */
    private $getCart;

    protected function _before()
    {
        $this->security = Mockery::mock(Security::class);
        $this->getCart  = Mockery::mock(FindOrCreateCartByCustomer::class);
    }

    public function getSystemUnderTest(): CartConverter
    {
        return new CartConverter($this->security, $this->getCart);
    }

    public function testGuestShouldNotGetACart()
    {
        $this->security
            ->shouldReceive('getUser')
            ->andReturnNull();

        $this->getCart->shouldNotReceive('execute');

        $this->getSystemUnderTest()->apply(
            Mockery::mock(Request::class),
            Mockery::mock(ParamConverter::class)
        );
    }

    public function testCustomerShouldGetACart()
    {
        /** @var User | MockInterface $customer */
        $customer = Mockery::mock(User::class);
        /** @var Cart | MockInterface $cart */
        $cart = Mockery::mock(Cart::class);
        /** @var ParamConverter|MockInterface $config */
        $config = Mockery::mock(ParamConverter::class);

        $request = new Request();
        $name    = 'cart';

        $this->security
            ->shouldReceive('getUser')
            ->andReturn($customer);

        $this->getCart
            ->shouldReceive('execute')
            ->with($customer)
            ->andReturn($cart);

        $config
            ->shouldReceive('getName')
            ->andReturn($name);

        $this->getSystemUnderTest()->apply($request, $config);

        self::assertEquals($cart, $request->attributes->get($name));
    }
}
