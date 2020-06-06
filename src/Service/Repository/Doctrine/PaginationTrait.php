<?php

namespace App\Service\Repository\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

trait PaginationTrait
{
    protected function getPagination(QueryBuilder $builder, int $currentPage, int $maxPerPage): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($builder));

        $paginator->setMaxPerPage($maxPerPage);
        $paginator->setCurrentPage($currentPage);

        return $paginator;
    }
}
