<?php

namespace App\Service\Pricing\Cart\Strategy;

use App\Entity\CartItem;
use App\Money\MoneyInterface;

interface CartItemStrategyInterface
{
    public function execute(CartItem $item): MoneyInterface;
}