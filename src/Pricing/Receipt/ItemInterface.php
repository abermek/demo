<?php

namespace App\Pricing\Receipt;

use App\Money\MoneyInterface;

interface ItemInterface
{
    public function getUnitPrice(): MoneyInterface;

    public function getGrandTotal(): MoneyInterface;

    public function getQuantity(): int;

    public function getProductName(): string;
}
