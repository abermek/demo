<?php

namespace App\Service\Repository\Doctrine;

use App\DTO\CartItem\CartItemCriteria;
use App\Entity\CartItem;
use App\Service\Repository\CartItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CartItemRepository implements CartItemRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function createQueryBuilder(CartItemCriteria $criteria): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('e')
            ->from(CartItem::class, 'e');

        if (!empty($criteria->product) && $criteria->product->getId()) {
            $qb
                ->andWhere($qb->expr()->eq('e.product', ':product'))
                ->setParameter('product', $criteria->product->getId());
        }

        if (!empty($criteria->cart) && $criteria->cart->getId()) {
            $qb
                ->andWhere($qb->expr()->eq('e.cart', ':cart'))
                ->setParameter('cart', $criteria->cart->getId());
        }

        return $qb;
    }

    public function first(CartItemCriteria $criteria): ?CartItem
    {
        if ($criteria->cart && !$criteria->cart->getId()) {
            return null;
        }

        return $this->createQueryBuilder($criteria)->getQuery()->getOneOrNullResult();
    }
}