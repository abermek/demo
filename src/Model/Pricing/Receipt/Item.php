<?php

namespace App\Model\Pricing\Receipt;

use App\Money\MoneyInterface;
use App\Pricing\Receipt\ItemInterface;

final class Item implements ItemInterface
{
    public function __construct(
        private string $productName,
        private int $quantity,
        private MoneyInterface $unitPrice,
        private MoneyInterface $grandTotal
    ) {
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): MoneyInterface
    {
        return $this->unitPrice;
    }

    public function getGrandTotal(): MoneyInterface
    {
        return $this->grandTotal;
    }
}
