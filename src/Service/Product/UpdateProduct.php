<?php

namespace App\Service\Product;

use App\DTO\Product\ProductDTO;
use App\Entity\Product;

class UpdateProduct
{
    public function execute(Product $product, ProductDTO $dto): Product
    {
        if (!empty($dto->getName())) {
            $product->updateName($dto->getName());
        }

        if (!empty($dto->getPrice())) {
            $product->updatePrice($dto->getPrice());
        }

        return $product;
    }
}
