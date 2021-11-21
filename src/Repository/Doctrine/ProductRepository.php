<?php

namespace App\Repository\Doctrine;

use App\DTO\Doctrine\ProductCriteria;
use App\DTO\Product\ProductFilters;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function first(ProductFilters $filters): ?Product
    {
        $criteria = ProductCriteria::fromFilters($filters);
        $criteria->setMaxResults(1);

        return $this->matching($criteria)->first() ?: null;
    }

    public function findOneBySlug(string $slug): ?Product
    {
        $filters = new ProductFilters();
        $filters->slug = $slug;

        return $this->first($filters);
    }
}
