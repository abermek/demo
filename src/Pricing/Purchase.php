<?php

namespace App\Pricing;

use App\Entity\Product;

interface Purchase
{
    public function getProduct(): Product;

    public function getQuantity(): int;
}
