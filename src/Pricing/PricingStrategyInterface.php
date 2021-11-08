<?php

namespace App\Pricing;

interface PricingStrategyInterface
{
    public function execute(PurchaseInterface ...$purchases): ReceiptInterface;
}
