<?php

namespace App\DTO;

use App\Exception\Pricing\Receipt\EmptyReceiptException;
use App\DTO\Receipt\Item;
use JetBrains\PhpStorm\Immutable;
use Money\Money;

#[Immutable]
final class Receipt
{
    private readonly array $items;

    public function __construct(private readonly Money $total, Item ...$items)
    {
        if (empty($items)) {
            throw new EmptyReceiptException();
        }

        $this->items = $items;
    }
}
