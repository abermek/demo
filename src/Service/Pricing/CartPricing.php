<?php

namespace App\Service\Pricing;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Model\Pricing\Receipt;
use App\Pricing\CartPricingStrategy;
use App\Pricing\ProductPricingStrategy;
use App\Service\Money\MoneyMath;

final class CartPricing implements CartPricingStrategy
{
    public function __construct(private ProductPricingStrategy $productPricingStrategy, private MoneyMath $moneyMath)
    {}

    public function execute(Cart $cart): Receipt
    {
        $items = [];
        $total = null;

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item) {
            $subtotal = $this->productPricingStrategy->execute($item->getProduct(), $item->getQuantity());

            is_null($total)
                ? $total = $subtotal->getGrandTotal()
                : $total = $this->moneyMath->add($total, $subtotal->getGrandTotal());

            $items = array_merge($items, $subtotal->getItems());
        }

        return new Receipt($total, ...$items);
    }
}
