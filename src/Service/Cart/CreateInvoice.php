<?php

namespace App\Service\Cart;

use App\Cart\CartInterface;
use App\Entity\CartItem;
use App\Exception\Cart\EmptyCartException;
use App\Pricing\Invoice\Invoice;
use App\Pricing\Invoice\InvoiceItem;
use App\Service\Pricing\Cart\Strategy\CartItemStrategyInterface;
use App\Service\Pricing\Cart\Strategy\CartStrategyInterface;

class CreateInvoice
{
    private CartStrategyInterface $cartStrategy;
    private CartItemStrategyInterface $cartItemStrategy;

    public function __construct(CartStrategyInterface $cartStrategy, CartItemStrategyInterface $cartItemStrategy)
    {
        $this->cartStrategy = $cartStrategy;
        $this->cartItemStrategy = $cartItemStrategy;
    }

    public function execute(CartInterface $cart): Invoice
    {
        if ($cart->isEmpty()) {
            throw new EmptyCartException();
        }

        $items = [];

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item) {
            $items[] = new InvoiceItem(
                $item->getProduct(),
                $item->getQuantity(),
                $this->cartItemStrategy->execute($item)
            );
        }

        return new Invoice(
            $cart->getCustomer(),
            $this->cartStrategy->execute($cart),
            ... $items
        );
    }
}