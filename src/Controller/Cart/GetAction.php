<?php

namespace App\Controller\Cart;

use App\Service\Cart\ActiveCart;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Pricing\Receipt;
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
    public function __construct(private ActiveCart $activeCart)
    {}

    public function __invoke()
    {
        return $this->activeCart->getReceipt();
    }
}
