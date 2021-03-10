<?php

namespace App\Controller\Cart;

use App\Pricing\CartPricingStrategy;
use App\Service\Cart\GetActiveCart;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\Receipt;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation as SWG;

/**
 * @OA\Response(
 *     response=200,
 *     description="Returns current Cart",
 *     @SWG\Model(type=Receipt::class)
 * )
 * @OA\Tag(name="Cart")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/cart', name: 'cart.get', methods: ['GET'])]
class GetAction
{
    public function __construct(private GetActiveCart $getActiveCart, private CartPricingStrategy $pricingStrategy)
    {}

    public function __invoke()
    {
        $cart = $this->getActiveCart->execute();

        return $cart->isEmpty()
            ? null
            : $this->pricingStrategy->execute($cart);
    }
}
