<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;

class AddProduct
{
    public function execute(Cart $cart, Product $product, int $quantity): void
    {
        $item = $cart->findProduct($product);

        if ($item) {
            $item->quantity += $quantity;
        } else {
            $item = new CartItem();
            $item->cart = $cart;
            $item->product = $product;
            $item->quantity = $quantity;

            $cart->items->add($item);
        }
    }
}
