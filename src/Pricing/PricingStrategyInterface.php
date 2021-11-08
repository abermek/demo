<?php

namespace App\Pricing;

use App\Model\Pricing\Receipt;

interface PricingStrategyInterface
{
    public function execute(PurchaseInterface ...$purchases): Receipt;
}
