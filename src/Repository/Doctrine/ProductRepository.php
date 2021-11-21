<?php

namespace App\Repository\Doctrine;

use App\DTO\Doctrine\ProductCriteria;
use App\DTO\Product\ProductFilters;
use App\Entity\Product;
use App\Service\Repository\Doctrine\PaginationTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Pagerfanta;

class ProductRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, Product::class);
    }

    public function all(ProductFilters $filters): Collection
    {
        return $this->matching(ProductCriteria::fromFilters($filters));
    }

    public function first(ProductFilters $filters): ?Product
    {
        $criteria = ProductCriteria::fromFilters($filters);
        $criteria->setMaxResults(1);

        return $this->matching($criteria)->first() ?: null;
    }

    public function paginate(ProductFilters $filters, int $pageNumber, int $itemsPerPage): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p');
        $qb->addCriteria(ProductCriteria::fromFilters($filters));

        return $this->getPagination($qb, $pageNumber, $itemsPerPage);
    }

    public function findOneBySlug(string $slug): ?Product
    {
        $filters = new ProductFilters();
        $filters->slug = $slug;

        return $this->first($filters);
    }
}
