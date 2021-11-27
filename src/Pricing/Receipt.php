<?php

namespace App\Pricing;

use App\Exception\Pricing\Receipt\EmptyReceiptException;
use App\Money\MoneyInterface;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Receipt
{
    private array $items;

    public function __construct(private MoneyInterface $total, ReceiptItem ...$items)
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

    public function getTotal(): MoneyInterface
    {
        return $this->total;
    }
}
