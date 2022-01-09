<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Cart\Item;

class AddItem
{
    public function execute(Cart $cart, Item $item): void
    {
        $buffer = $cart->findProduct($item->product);

        if ($buffer) {
            $buffer->quantity += $item->quantity;
        } else {
            $item->cart = $cart;

            $cart->items->add($item);
        }
    }
}
