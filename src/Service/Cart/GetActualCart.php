<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class GetActualCart
{
    public function __construct(private EntityManagerInterface $em, private Security $security)
    {
    }

    public function execute(): Cart
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart($user);

            $user->setCart($cart);
            $this->em->persist($cart);
        }

        return $cart;
    }
}
