<?php

namespace App\DTO;

use App\Entity\Product;

class Purchase
{
    public ?Product $product = null;
    public ?int $quantity = null;
}
