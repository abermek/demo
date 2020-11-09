<?php

namespace App\Controller\Cart;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\CartItem;
use App\Form\Type\Cart\CartItemType;
use App\Pricing\CartPricingStrategy;
use App\Service\Cart\GetActiveCart;
use App\Service\Cart\PutProductToCart;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/cart", name="cart.put", methods={"POST"}) */
class PutAction
{
    use EntityManagerTrait;
    use FormFactoryTrait;

    private GetActiveCart $getActiveCart;
    private CartPricingStrategy $pricing;
    private PutProductToCart $put;

    public function __construct(GetActiveCart $getActiveCart, CartPricingStrategy $pricing, PutProductToCart $put)
    {
        $this->getActiveCart = $getActiveCart;
        $this->pricing = $pricing;
        $this->put = $put;
    }

    public function __invoke(Request $request)
    {
        $cart = $this->getActiveCart->execute();

        $item = new CartItem();
        $form = $this->formFactory->create(CartItemType::class, $item);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $this->put->execute($cart, $item->getProduct(), $item->getQuantity());

        $this->em->flush();
        $this->em->refresh($cart);

        return $this->pricing->execute($cart);
    }
}
