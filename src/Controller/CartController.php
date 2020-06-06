<?php

namespace App\Controller;

use App\Cart\CartInterface;
use App\DTO\Response\FormValidationFailedResponse;
use App\Entity\CartItem;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            return View::create(new FormValidationFailedResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $cart->addItem($item);

        $this->em->flush();
        $this->em->refresh($cart);

        return $cart;
    }
}
