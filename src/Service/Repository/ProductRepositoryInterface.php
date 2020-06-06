<?php

namespace App\Service\Repository;

use App\DTO\Product\ProductCriteria;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use Pagerfanta\Pagerfanta;

interface ProductRepositoryInterface
{
    public function create(Product $product): void;

    public function remove(Product $product): void;

    public function find(ProductCriteria $criteria): Collection;

    public function paginate(ProductCriteria $criteria, int $pageNumber, int $itemsPerPage): Pagerfanta;
}
