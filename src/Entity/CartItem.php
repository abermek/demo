<?php

namespace App\Entity;

use App\Exception\Pricing\Purchase\EmptyPropertyException;
use App\Money\MoneyInterface;
use App\Pricing\PurchaseInterface;

class CartItem implements PurchaseInterface
{
    protected ?int $id;
    protected ?Product $product = null;
    protected ?Cart $cart = null;
    protected ?int $quantity = null;

    public function getQuantity(): ?int
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

    public function increaseQuantity(int $amount): CartItem
    {
        $this->quantity += $amount;

        return $this;
    }

    public function getProductName(): string
    {
        if (!$this->product || empty($this->product->getName())) {
            throw new EmptyPropertyException('product.name');
        }

        return $this->product->getName();
    }

    public function getProductId(): string
    {
        if (!$this->product || empty($this->product->getId())) {
            throw new EmptyPropertyException('product.id');
        }

        return $this->product->getId();
    }

    public function getProductPrice(): MoneyInterface
    {
        if (!$this->product || empty($this->product->getPrice())) {
            throw new EmptyPropertyException('product.price');
        }

        return $this->product->getPrice();
    }

    public function getProductQuantity(): int
    {
        if ($this->quantity === null) {
            throw new EmptyPropertyException('quantity');
        }

        return $this->quantity;
    }
}
