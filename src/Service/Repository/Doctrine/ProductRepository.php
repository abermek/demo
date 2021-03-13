<?php

namespace App\Service\Repository\Doctrine;

use App\DTO\Product\ProductCriteria;
use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;

class ProductRepository implements ProductRepositoryInterface
{
    use PaginationTrait;

    public function __construct(private EntityManagerInterface $em)
    {
    }

    private function createQueryBuilder(ProductCriteria $criteria): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('p')
            ->from(Product::class, 'p');

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

    public function find(ProductCriteria $criteria): array
    {
        return $this->createQueryBuilder($criteria)
            ->getQuery()
            ->getResult();
    }

    public function paginate(ProductCriteria $criteria, int $pageNumber, int $itemsPerPage): Pagerfanta
    {
        return $this->getPagination(
            $this->createQueryBuilder($criteria),
            $pageNumber,
            $itemsPerPage
        );
    }

    public function findOneBySlug(string $slug): ?Product
    {
        $criteria = new ProductCriteria();
        $criteria->slug = $slug;

        return $this->find($criteria)[0] ?? null;
    }
}
