<?php

namespace App\Controller\Cart;

use App\Attribute\Input;
use App\DTO\Purchase;
use App\Entity\Cart;
use App\Form\Type\PurchaseType;
use App\Model\Pricing\Receipt;
use App\Pricing\PricingStrategyInterface;
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
        Cart $cart,
        PricingStrategyInterface $pricing,
        #[Input(PurchaseType::class)] Purchase $purchase
    ): Receipt {
        $cart->addProduct($purchase->product, $purchase->quantity);
        $em->flush();

        return $pricing->execute(... $cart->getItems());
    }
}
