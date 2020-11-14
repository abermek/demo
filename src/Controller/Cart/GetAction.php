<?php

namespace App\Controller\Cart;

use App\Pricing\CartPricingStrategy;
use App\Service\Cart\GetActiveCart;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\Receipt;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation as SWG;

/**
 * @Route("/cart", name="cart.get", methods={"GET"})
 *
 * @OA\Response(
 *     response=200,
 *     description="Returns current Cart",
 *     @SWG\Model(type=Receipt::class)
 * )
 * @OA\Tag(name="Cart")
 * @SWG\Security(name="Bearer")
 */
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
