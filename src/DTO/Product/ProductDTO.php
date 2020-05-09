<?php declare(strict_types=1);

namespace App\DTO\Product;

use App\Money\MoneyInterface;

class ProductDTO
{
    protected ?string $name = null;
    protected ?MoneyInterface $price = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ProductDTO
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ?MoneyInterface
    {
        return $this->price;
    }

    public function setPrice(?MoneyInterface $price): ProductDTO
    {
        $this->price = $price;
        return $this;
    }
}
