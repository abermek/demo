<?php

namespace App\Controller\Cart;

use App\Attribute\Input;
use App\DTO\Purchase;
use App\Entity\Cart;
use App\Form\Type\PurchaseType;
use App\Pricing\Receipt;
use App\Pricing\PricingStrategy;
use App\Service\Cart\AddProduct;
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
        AddProduct $addProduct,
        PricingStrategy $pricing,
        #[Input(PurchaseType::class)] Purchase $purchase
    ): Receipt {
        $addProduct->execute($cart, $purchase->product, $purchase->quantity);
        $em->flush();

        return $pricing->execute(... $cart->items);
    }
}
