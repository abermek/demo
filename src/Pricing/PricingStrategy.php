<?php

namespace App\Pricing;

interface PricingStrategy
{
    public function execute(PurchaseInterface ...$purchases): Receipt;
}
