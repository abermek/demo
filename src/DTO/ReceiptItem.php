<?php

namespace App\DTO;

use App\Money\MoneyInterface;

final class ReceiptItem
{
    public string $name;
    public int $quantity;
    public MoneyInterface $price;
    public MoneyInterface $total;

    public function __construct(string $name, int $quantity, MoneyInterface $price, MoneyInterface $total)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
    }
}
