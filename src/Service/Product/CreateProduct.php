<?php

namespace App\Service\Product;

use App\DTO\Product\ProductDTO;
use App\Entity\Product;
use App\Entity\Security\User;
use App\Service\Repository\Doctrine\ProductRepository;

class CreateProduct
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(ProductDTO $dto, User $owner): Product
    {
        $product = new Product(
            $dto->getName(),
            $dto->getPrice(),
            $owner
        );

        $this->productRepository->create($product);

        return $product;
    }
}