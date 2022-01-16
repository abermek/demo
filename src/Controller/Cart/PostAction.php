<?php

namespace App\Controller\Cart;

use App\Attribute\Input;
use App\Contract\Pricing\PricingStrategy;
use App\DTO\Receipt;
use App\Entity\Cart;
use App\Entity\Cart\Item;
use App\Form\Type\Cart\ItemType;
use App\Service\Cart\AddItem;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\RequestBody(request=ItemType::class, required=true)
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
        AddItem $addProduct,
        PricingStrategy $pricing,
        #[Input(ItemType::class)] Item $item
    ): Receipt {
        $addProduct->execute($cart, $item);
        $em->flush();

        return $pricing->execute($cart);
    }
}
