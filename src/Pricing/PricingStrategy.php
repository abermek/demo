<?php

namespace App\Pricing;

interface PricingStrategy
{
    public function execute(Purchase ...$purchases): Receipt;
}
