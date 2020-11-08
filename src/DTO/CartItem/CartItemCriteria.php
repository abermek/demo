<?php

namespace App\DTO\CartItem;

use App\Cart\CartInterface;
use App\Entity\Product;

class CartItemCriteria
{
    public ?CartInterface $cart;
    public ?Product $product;
}