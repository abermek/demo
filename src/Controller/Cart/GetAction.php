<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Exception\Cart\EmptyCartException;
use App\Pricing\ReceiptInterface;
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
    public function __invoke(ActiveCart $activeCart, Cart $cart): ?ReceiptInterface
    {
        try {
            return $activeCart->getReceipt();
        } catch (EmptyCartException) {
            return null;
        }
    }
}
