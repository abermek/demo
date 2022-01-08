<?php

namespace App\Doctrine\Pagination;

use App\Doctrine\Criteria\ProductCriteria;
use App\Doctrine\Pagination;
use App\Doctrine\Repository\ProductRepository;
use App\DTO\Product\Search;
use Pagerfanta\Pagerfanta;

class ProductPagination
{
    public function __construct(private ProductRepository $repository, private Pagination $pagination)
    {
    }

    public function execute(Search $search, int $page, int $limit): Pagerfanta
    {
        $qb = $this->repository->createQueryBuilder('p');
        $qb->addCriteria(new ProductCriteria($search));

        return $this->pagination->execute($qb, $page, $limit);
    }
}
