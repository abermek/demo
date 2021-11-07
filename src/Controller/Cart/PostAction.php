<?php

namespace App\Controller\Cart;

use App\Attribute\Input;
use App\DTO\Purchase;
use App\Form\Type\PurchaseType;
use App\Model\Pricing\Receipt;
use App\Pricing\ReceiptInterface;
use App\Service\Cart\ActiveCart;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\RequestBody(request=PurchaseType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Put Product To The Cart",
 *     @SWG\Model(type=Receipt::class)
 * )
 * @OA\Tag(name="Cart")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/cart', name: 'cart.put', methods: ['POST'])]
class PostAction
{
    public function __invoke(
        EntityManagerInterface $em,
        ActiveCart $cart,
        #[Input(PurchaseType::class)] Purchase $purchase
    ): ?ReceiptInterface {
        $cart->addPurchase($purchase);
        $em->flush();

        return $cart->getReceipt();
    }
}
