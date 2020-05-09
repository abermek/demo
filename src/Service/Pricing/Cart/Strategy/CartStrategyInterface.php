<?php

namespace App\Service\Pricing\Cart\Strategy;

use App\Cart\CartInterface;
use App\Money\MoneyInterface;

interface CartStrategyInterface
{
    public function execute(CartInterface $cart): MoneyInterface;
}