<?php

namespace App\Pricing;

use App\Exception\Pricing\Receipt\EmptyReceiptException;
use JetBrains\PhpStorm\Immutable;
use Money\Money;

#[Immutable]
final class Receipt
{
    private array $items;

    public function __construct(private Money $total, ReceiptItem ...$items)
    {
        if (empty($items)) {
            throw new EmptyReceiptException();
        }

        $this->items = $items;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }
}
