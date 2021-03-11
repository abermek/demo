<?php

namespace App\Pricing;

use App\Entity\Product;

interface ProductPricingStrategy
{
    public function execute(Product $product, int $quantity): ReceiptInterface;
}