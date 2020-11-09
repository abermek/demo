<?php

namespace App\Service\Pricing;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\DTO\Receipt;
use App\Pricing\CartPricingStrategy;
use App\Pricing\ProductPricingStrategy;
use App\Service\Money\MoneyMath;

final class CartPricing implements CartPricingStrategy
{
    private ProductPricingStrategy $productPricingStrategy;
    private MoneyMath $moneyMath;

    public function __construct(ProductPricingStrategy $productPricingStrategy, MoneyMath $moneyMath)
    {
        $this->productPricingStrategy = $productPricingStrategy;
        $this->moneyMath = $moneyMath;
    }

    public function execute(Cart $cart): Receipt
    {
        $items = [];
        $total = null;

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item) {
            $subtotal = $this->productPricingStrategy->execute($item->getProduct(), $item->getQuantity());

            is_null($total)
                ? $total = $subtotal->getTotal()
                : $total = $this->moneyMath->add($total, $subtotal->getTotal());

            $items = array_merge($items, $subtotal->getItems());
        }

        return new Receipt($total, ...$items);
    }
}
