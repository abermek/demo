<?php

namespace App\DTO;

use App\Money\MoneyInterface;

final class ReceiptItem
{
    private string $name;
    private int $quantity;
    private MoneyInterface $price;
    private MoneyInterface $total;

    public function __construct(string $name, int $quantity, MoneyInterface $price, MoneyInterface $total)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): MoneyInterface
    {
        return $this->price;
    }

    public function getTotal(): MoneyInterface
    {
        return $this->total;
    }
}