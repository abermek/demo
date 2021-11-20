<?php

namespace App\Repository\Doctrine;

use App\DTO\Product\ProductCriteria;
use App\Entity\Product;
use App\Service\Repository\Doctrine\PaginationTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Pagerfanta;

class ProductRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, Product::class);
    }

    private function createProductQueryBuilder(ProductCriteria $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($criteria->name)) {
            $qb
                ->andWhere($qb->expr()->eq('p.name', ':name_eq'))
                ->setParameter('name_eq', $criteria->name);
        }

        if (!empty($criteria->slug)) {
            $qb
                ->andWhere($qb->expr()->eq('p.slug', ':slug_eq'))
                ->setParameter('slug_eq', $criteria->slug);
        }

        return $qb;
    }

    public function all(ProductCriteria $criteria): array
    {
        return $this->createProductQueryBuilder($criteria)
            ->getQuery()
            ->getResult();
    }

    public function first(ProductCriteria $criteria): ?Product
    {
        return $this->createProductQueryBuilder($criteria)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function paginate(ProductCriteria $criteria, int $pageNumber, int $itemsPerPage): Pagerfanta
    {
        return $this->getPagination(
            $this->createProductQueryBuilder($criteria),
            $pageNumber,
            $itemsPerPage
        );
    }

    public function findOneBySlug(string $slug): ?Product
    {
        $criteria = new ProductCriteria();
        $criteria->slug = $slug;

        return $this->first($criteria);
    }
}
