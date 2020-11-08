<?php

namespace App\DTO;

use App\Money\MoneyInterface;

final class Receipt
{
    private array $items;
    private MoneyInterface $total;

    public function __construct(MoneyInterface $total, ReceiptItem ...$items)
    {
        $this->items = $items;
        $this->total = $total;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): MoneyInterface
    {
        return $this->total;
    }
}