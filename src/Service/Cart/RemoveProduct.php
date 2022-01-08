<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;

class RemoveProduct
{
    public function execute(Cart $cart, Product $product, int $quantity): void
    {
        $items = $cart->getItems();
        $item = $items->filter(fn(CartItem $item) => $item->getProduct() === $product)->first();

        if ($item === null) {
            return;
        }

        $item->setQuantity($item->getQuantity() - $quantity);

        if ($item->getQuantity() <= 0) {
            $items->removeElement($item);
        }
    }
}
