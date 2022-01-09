<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use App\Pricing\Purchase;

class CartItem implements Purchase
{
    use GeneratedValueTrait;

    public ?Product $product = null;
    public ?Cart $cart = null;
    public ?int $quantity = null;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
