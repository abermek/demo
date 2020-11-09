<?php

namespace App\Pricing;

use App\DTO\Receipt;
use App\Entity\Cart;

interface CartPricingStrategy
{
    public function execute(Cart $cart): Receipt;
}
