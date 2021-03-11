<?php

namespace App\Pricing;

use App\Money\MoneyInterface;

interface PurchaseInterface
{
    public function getProductName(): string;

    public function getProductId(): string;

    public function getProductQuantity(): int;

    public function getProductPrice(): MoneyInterface;
}