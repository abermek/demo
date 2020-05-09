<?php

namespace App\Service\Repository\Doctrine;

use App\DTO\Page;
use App\Exception\BadRequest\PageOutOfRangeException;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;

trait PaginationTrait
{
    protected function getPagination(QueryBuilder $builder, int $currentPage, int $maxPerPage): Page
    {
        try {
            $paginator = new Pagerfanta(new DoctrineORMAdapter($builder));

            $paginator->setMaxPerPage($maxPerPage);
            $paginator->setCurrentPage($currentPage);

            return new Page(
                $paginator->getCurrentPageResults(),
                $currentPage,
                $paginator->getNbPages()
            );
        } catch (OutOfRangeCurrentPageException $e) {
            throw new PageOutOfRangeException($currentPage);
        }
    }
}
