<?php

namespace App\Service\Repository\Doctrine;

use App\Entity\Cart;
use App\Service\Repository\CartRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class CartRepository implements CartRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Cart $cart): void
    {
        $this->em->persist($cart);
    }
}