<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;

class FindOrCreateCartByCustomer
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function execute(User $customer): Cart
    {
        $cart = $customer->getCart();

        if (is_null($cart)) {
            $cart = new Cart($customer);

            $this->em->persist($cart);
        }

        return $cart;
    }
}