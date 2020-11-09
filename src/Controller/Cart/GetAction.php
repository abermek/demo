<?php

namespace App\Controller\Cart;

use App\Pricing\CartPricingStrategy;
use App\Service\Cart\GetActiveCart;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/cart", name="cart.get", methods={"GET"}) */
class GetAction
{
    private GetActiveCart $getActiveCart;
    private CartPricingStrategy $pricingStrategy;

    public function __construct(GetActiveCart $getActiveCart, CartPricingStrategy $pricingStrategy)
    {
        $this->getActiveCart = $getActiveCart;
        $this->pricingStrategy = $pricingStrategy;
    }

    public function __invoke()
    {
        $cart = $this->getActiveCart->execute();

        return $cart->isEmpty()
            ? null
            : $this->pricingStrategy->execute($cart);
    }
}
