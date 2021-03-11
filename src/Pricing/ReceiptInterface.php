<?php

namespace App\Pricing;

use App\Money\MoneyInterface;

interface ReceiptInterface
{
    public function getItems(): iterable;

    public function getGrandTotal(): MoneyInterface;
}