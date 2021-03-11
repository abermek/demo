<?php

namespace App\Service\Pricing;

use App\Entity\Product;
use App\Model\Pricing\Receipt;
use App\Model\Pricing\Receipt\Item;
use App\Pricing\ProductPricingStrategy;
use App\Service\Money\MoneyMath;

final class ProductPricing implements ProductPricingStrategy
{
    public function __construct(private MoneyMath $moneyMath)
    {}

    public function execute(Product $product, int $quantity): Receipt
    {
        $total = $this->moneyMath->multiply($product->getPrice(), $quantity);
        $item = new Item($product->getName(), $quantity, $product->getPrice(), $total);

        return new Receipt($total, $item);
    }
}
