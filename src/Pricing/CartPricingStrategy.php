<?php

namespace App\Pricing;

use App\Cart\CartInterface;
use App\DTO\Receipt;

interface CartPricingStrategy
{
    public function execute(CartInterface $cart): Receipt;
}