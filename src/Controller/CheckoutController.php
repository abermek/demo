<?php

namespace App\Controller;

use App\Cart\CartInterface;
use App\Exception\Cart\EmptyCartException;
use App\Service\Cart\CreateInvoice;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/checkout", name="checkout") */
class CheckoutController
{
    /** @Route(name="", methods={"GET"}) */
    public function index(CartInterface $cart, CreateInvoice $createInvoice)
    {
        try {
            return $createInvoice->execute($cart);
        } catch (EmptyCartException $e) {
            return null; // HTTP 204 No Content
        }
    }
}