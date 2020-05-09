<?php

namespace App\DTO\Cart;

use App\Entity\Product;

class CartItemDTO
{
    private ?Product $product = null;
    private ?int $quantity = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): CartItemDTO
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): CartItemDTO
    {
        $this->quantity = $quantity;
        return $this;
    }
}
