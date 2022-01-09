<?php

namespace App\Entity\Cart;

use App\Entity\Cart;
use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Product;

class Item
{
    use GeneratedValueTrait;

    public ?Product $product = null;
    public ?Cart $cart = null;
    public ?int $quantity = null;
}
