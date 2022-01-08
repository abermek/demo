<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;

class AddProduct
{
    public function execute(Cart $cart, Product $product, int $quantity): void
    {
        $items = $cart->getItems();
        $item = $items->filter(fn(CartItem $item) => $item->getProduct() === $product)->first();

        if ($item) {
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            $item = new CartItem();
            $item
                ->setCart($cart)
                ->setProduct($product)
                ->setQuantity($quantity);

            $items->add($item);
        }
    }
}
