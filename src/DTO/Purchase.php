<?php

namespace App\DTO;

use App\Entity\Product;

class Purchase
{
    public ?Product $product;
    public ?int $quantity;
}
