<?php

namespace App\Entity;

use App\Exception\Pricing\Purchase\EmptyPropertyException;
use App\Money\MoneyInterface;
use App\Pricing\Purchase;

class CartItem implements Purchase
{
    protected ?int $id;
    protected ?Product $product = null;
    protected ?Cart $cart = null;
    protected ?int $quantity = null;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): CartItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): CartItem
    {
        $this->product = $product;

        return $this;
    }

    public function setCart(?Cart $cart): CartItem
    {
        $this->cart = $cart;

        return $this;
    }
}
