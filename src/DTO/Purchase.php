<?php

namespace App\DTO;

use App\Entity\Product;

class Purchase implements InputInterface
{
    public ?Product $product;
    public ?int $quantity;
}
