<?php

namespace App\Controller;

use App\Cart\CartInterface;
use App\DTO\View\CartView;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\Cart\CartItemDTO;
use App\Form\Type\Cart\CartItemType;

/** @Route("/cart", name="cart_") */
class CartController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route(name="add", methods={"POST"})
     * @ParamConverter("item", options={"form"=CartItemType::class})
     */
    public function put(CartInterface $cart, CartItemDTO $item): CartView
    {
        $cart->addItem(
            new CartItem(
                $item->getProduct(),
                $item->getQuantity()
            )
        );

        $this->em->flush();
        $this->em->refresh($cart);

        return new CartView($cart);
    }
}
