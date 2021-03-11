<?php

namespace App\Pricing;

use App\Entity\Cart;

interface CartPricingStrategy
{
    public function execute(Cart $cart): ReceiptInterface;
}
