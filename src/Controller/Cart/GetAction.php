<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\DTO\Receipt;
use App\Contract\Pricing\PricingStrategy;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

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
    public function __invoke(Cart $cart, PricingStrategy $pricing): ?Receipt
    {
        return count($cart) ? $pricing->execute($cart) : null;
    }
}
