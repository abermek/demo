<?php

namespace App\Pagination\Doctrine;

use App\DTO\Doctrine\ProductCriteria;
use App\DTO\Product\ProductFilters;
use App\Repository\Doctrine\ProductRepository;
use Pagerfanta\Pagerfanta;

class ProductPagination
{
    public function __construct(private ProductRepository $repository, private DoctrinePagination $pagination)
    {
    }

    public function execute(int $page, int $limit, ?ProductFilters $filters = null): Pagerfanta
    {
        $qb = $this->repository->createQueryBuilder('p');

        if ($filters) {
            $qb->addCriteria(ProductCriteria::fromFilters($filters));
        }

        return $this->pagination->execute($qb, $page, $limit);
    }
}
