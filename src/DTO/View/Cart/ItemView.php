<?php

namespace App\DTO\View\Cart;

use App\Entity\CartItem;
use App\Entity\Product;

final class ItemView
{
    public Product $product;
    public int $quantity;

    public function __construct(CartItem $item)
    {
        $this->product = $item->getProduct();
        $this->quantity = $item->getQuantity();
    }
}