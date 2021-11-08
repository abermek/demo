<?php

namespace App\Pricing;

use App\Money\MoneyInterface;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ReceiptItem
{
    public function __construct(
        private string $name,
        private int $quantity,
        private MoneyInterface $price,
        private MoneyInterface $total
    ) {
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
