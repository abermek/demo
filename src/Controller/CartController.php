<?php

namespace App\Controller;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\CartItem;
use App\Pricing\CartPricingStrategy;
use App\Service\Cart\GetActiveCart;
use App\Service\Cart\PutProductToCart;
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
    public function put(GetActiveCart $getActiveCart, CartPricingStrategy $pricing, PutProductToCart $put, Request $request)
    {
        $cart = $getActiveCart->execute();

        $item = new CartItem();
        $form = $this->formFactory->create(CartItemType::class, $item);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $put->execute($cart, $item->getProduct(), $item->getQuantity());

        $this->em->flush();
        $this->em->refresh($cart);

        return $pricing->execute($cart);
    }

    /**
     * @Route(name="get", methods={"GET"})
     */
    public function get(GetActiveCart $getActiveCart, CartPricingStrategy $pricingStrategy)
    {
        $cart = $getActiveCart->execute();

        return $cart->isEmpty()
            ? null
            : $pricingStrategy->execute($cart);
    }
}
