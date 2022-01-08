<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;

class FindOrCreate
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function execute(User $user): Cart
    {
        $cart = $user->getCart();

        if ($cart === null) {
            $cart = new Cart($user);

            $user->setCart($cart);
            $this->em->persist($cart);
        }

        return $cart;
    }
}
