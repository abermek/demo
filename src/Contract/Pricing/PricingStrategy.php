<?php

namespace App\Contract\Pricing;

use App\DTO\Receipt;
use App\Entity\Cart;

interface PricingStrategy
{
    public function execute(Cart $cart): Receipt;
}
