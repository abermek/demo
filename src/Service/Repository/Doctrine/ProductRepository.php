<?php

namespace App\Service\Repository\Doctrine;

use App\DTO\Product\ProductCriteria;
use App\DTO\Page;
use App\Entity\Product;
use App\Service\Repository\ProductRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ProductRepository implements ProductRepositoryInterface
{
    use PaginationTrait;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Product $product): void
    {
        $this->em->persist($product);
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
    }

    private function createQueryBuilder(ProductCriteria $criteria): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('p')
            ->from(Product::class, 'p');

        if (!empty($criteria->getName())) {
            $qb
                ->andWhere($qb->expr()->eq('p.name', ':name_eq'))
                ->setParameter('name_eq', $criteria->getName());
        }

        return $qb;
    }

    public function find(ProductCriteria $criteria): Collection
    {
        return $this->createQueryBuilder($criteria)
            ->getQuery()
            ->getResult();
    }

    public function paginate(ProductCriteria $criteria, int $pageNumber, int $itemsPerPage): Page
    {
        return $this->getPagination(
            $this->createQueryBuilder($criteria),
            $pageNumber,
            $itemsPerPage
        );
    }
}
