<?php

namespace App\Service\Pricing\Cart\Strategy;

use App\Entity\CartItem;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyCalculator;

class CartItemStrategy implements CartItemStrategyInterface
{
    private MoneyCalculator $calculator;

    public function __construct(MoneyCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function execute(CartItem $item): MoneyInterface
    {
        return $this->calculator->multiply($item->getProduct()->getPrice(), $item->getQuantity());
    }
}