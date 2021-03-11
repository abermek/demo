<?php

namespace App\Service\Repository\Doctrine;

use App\DTO\CartItem\CartItemCriteria;
use App\Entity\CartItem;
use App\Repository\CartItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    private function createQueryBuilder(CartItemCriteria $criteria): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('e')
            ->from(CartItem::class, 'e');

        if (!is_null($criteria->productId)) {
            $qb
                ->andWhere($qb->expr()->eq('e.product', ':product'))
                ->setParameter('product', $criteria->productId);
        }

        if (!is_null($criteria->cartId)) {
            $qb
                ->andWhere($qb->expr()->eq('e.cart', ':cart'))
                ->setParameter('cart', $criteria->cartId);
        }

        return $qb;
    }

    public function findOne(CartItemCriteria $criteria): ?CartItem
    {
        return $this->createQueryBuilder($criteria)->getQuery()->getOneOrNullResult();
    }
}
