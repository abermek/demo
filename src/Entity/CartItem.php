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
        if (!$this->product) {
            throw new EmptyPropertyException('product');
        }

        $value = $this->product->getName();
        if (empty($value)) {
            throw new EmptyPropertyException('product.name');
        }

        return $value;
    }

    public function getProductId(): string
    {
        if (!$this->product) {
            throw new EmptyPropertyException('product');
        }

        $value = $this->product->getId();
        if (empty($value)) {
            throw new EmptyPropertyException('product.id');
        }

        return (string) $value;
    }

    public function getProductPrice(): MoneyInterface
    {
        if (!$this->product) {
            throw new EmptyPropertyException('product');
        }

        $value = $this->product->getPrice();
        if (empty($value)) {
            throw new EmptyPropertyException('product.price');
        }

        return $value;
    }

    public function getProductQuantity(): int
    {
        if (empty($this->quantity)) {
            throw new EmptyPropertyException('quantity');
        }

        return $this->quantity;
    }
}
