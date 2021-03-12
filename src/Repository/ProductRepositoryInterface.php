<?php

namespace App\Repository;

use App\DTO\Product\ProductCriteria;
use Doctrine\Common\Collections\Collection;
use Pagerfanta\Pagerfanta;

interface ProductRepositoryInterface
{
    public function find(ProductCriteria $criteria): array;

    public function paginate(ProductCriteria $criteria, int $pageNumber, int $itemsPerPage): Pagerfanta;
}
