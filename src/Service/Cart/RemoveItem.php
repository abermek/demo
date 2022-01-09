<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Cart\Item;

class RemoveItem
{
    public function execute(Cart $cart, Item $item): void
    {
        $buffer = $cart->findProduct($item->product);

        if ($buffer === null) {
            return;
        }

        $buffer->quantity -= $item->quantity;

        if ($buffer->quantity <= 0) {
            $cart->items->removeElement($buffer);
        }
    }
}
