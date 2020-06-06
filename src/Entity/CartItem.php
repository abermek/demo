<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class CartItem
{
    private ?int $id;
    private ?Product $product = null;
    private ?Cart $cart = null;
    private ?int $quantity = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
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

    public function setQuantity(?int $quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function increaseQuantity(int $amount): CartItem
    {
        $this->quantity += $amount;

        return $this;
    }
}
