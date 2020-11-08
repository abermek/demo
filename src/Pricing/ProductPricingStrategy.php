<?php

namespace App\Pricing;

use App\Entity\Product;
use App\DTO\Receipt;

interface ProductPricingStrategy
{
    public function execute(Product $product, int $quantity): Receipt;
}