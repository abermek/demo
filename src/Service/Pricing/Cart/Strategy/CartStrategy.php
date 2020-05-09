<?php

namespace App\Service\Pricing\Cart\Strategy;

use App\Cart\CartInterface;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyCalculator;

class CartStrategy implements CartStrategyInterface
{
    private CartItemStrategyInterface $itemStrategy;
    private MoneyCalculator $calculator;

    public function __construct(CartItemStrategyInterface $itemStrategy, MoneyCalculator $calculator)
    {
        $this->itemStrategy = $itemStrategy;
        $this->calculator = $calculator;
    }

    public function execute(CartInterface $cart): MoneyInterface
    {
        $total = null;

        foreach ($cart->getItems() as $item) {
            $subtotal = $this->itemStrategy->execute($item);

            $total = $total === null
                ? $subtotal
                : $this->calculator->add($total, $subtotal);
        }

        return $total;
    }
}