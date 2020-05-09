<?php

namespace App\Service\Product;

use App\DTO\Product\ProductDTO;
use App\Entity\Product;
use App\Entity\Security\User;
use App\Service\Repository\Doctrine\ProductRepository;

class DeleteProduct
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(Product $product): void
    {
        $this->productRepository->remove($product);
    }
}