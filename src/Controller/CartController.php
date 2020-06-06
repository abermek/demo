<?php

namespace App\Controller;

use App\Cart\CartInterface;
use App\Entity\CartItem;
use App\Exception\BadRequest\FormValidationFailedException;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\Cart\CartItemType;

/** @Route("/cart", name="cart_") */
class CartController
{
    use EntityManagerTrait;
    use FormFactoryTrait;

    /**
     * @Route(name="add", methods={"POST"})
     */
    public function put(CartInterface $cart, Request $request)
    {
        $item = new CartItem();
        $form = $this->formFactory->create(CartItemType::class, $item);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            throw new FormValidationFailedException($form->getErrors(true));
        }

        $cart->addItem($item);

        $this->em->flush();
        $this->em->refresh($cart);

        return $cart;
    }
}
