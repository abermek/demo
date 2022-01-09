<?php

namespace App\DTO\Receipt;

use JetBrains\PhpStorm\Immutable;
use Money\Money;

#[Immutable]
final class Item
{
    public function __construct(
        private readonly string $name,
        private readonly int $quantity,
        private readonly Money $price,
        private readonly Money $total
    ) {
    }
}
