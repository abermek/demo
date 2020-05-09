<?php

namespace App\Controller;

use App\Cart\CartInterface;
use App\DTO\View\InvoiceView;
use App\Service\Cart\CreateInvoice;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/checkout", name="checkout") */
class CheckoutController
{
    /** @Route(name="", methods={"GET"}) */
    public function index(CartInterface $cart, CreateInvoice $createInvoice): ?InvoiceView
    {
        if ($cart->isEmpty()) {
            return null; // HTTP 204 No Content
        }

        $invoice = $createInvoice->execute($cart);

        return new InvoiceView($invoice);
    }
}