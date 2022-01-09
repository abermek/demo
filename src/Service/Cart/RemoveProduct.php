<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Product;

class RemoveProduct
{
    public function execute(Cart $cart, Product $product, int $quantity): void
    {
        $item = $cart->findProduct($product);

        if ($item === null) {
            return;
        }

        $item->quantity -= $quantity;

        if ($item->quantity <= 0) {
            $cart->items->removeElement($item);
        }
    }
}
