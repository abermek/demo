<?php

namespace App\DTO\Product;

use App\DTO\InputInterface;

class ProductCriteria implements InputInterface
{
    public ?string $name = null;
    public ?string $slug = null;
}
