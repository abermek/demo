<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;

class FindOrCreate
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function execute(User $user): Cart
    {
        if ($user->cart === null) {
            $cart = new Cart();
            $cart->owner = $user;

            $user->cart = $cart;
            $this->em->persist($cart);
        }

        return $user->cart;
    }
}
