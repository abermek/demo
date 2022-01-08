<?php

namespace App\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class Pagination
{
    public function execute(QueryBuilder $qb, int $page, int $limit): Pagerfanta
    {
        $paginator = new Pagerfanta(new QueryAdapter($qb));

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
