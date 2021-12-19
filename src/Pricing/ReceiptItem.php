<?php

namespace App\Pricing;

use JetBrains\PhpStorm\Immutable;
use Money\Money;

#[Immutable]
final class ReceiptItem
{
    public function __construct(
        private string $name,
        private int $quantity,
        private Money $price,
        private Money $total
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

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }
}
