<?php

namespace App\DTO;

use App\Money\MoneyInterface;

final class Receipt
{
    public array $items;
    public MoneyInterface $total;

    public function __construct(MoneyInterface $total, ReceiptItem ...$items)
    {
        $this->items = $items;
        $this->total = $total;
    }
}
