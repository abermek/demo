<?php

namespace App\DTO\View;

use App\Entity\Product;
use App\Money\MoneyInterface;

final class ProductView
{
    public ?int $id;
    public ?string $name;
    public ?MoneyInterface $price;

    public function __construct(Product $product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
    }
}