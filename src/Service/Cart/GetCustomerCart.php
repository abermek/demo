<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Service\Repository\CartRepositoryInterface;

class GetCustomerCart
{
    private CartRepositoryInterface $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(User $customer): Cart
    {
        $cart = $customer->getCart();

        if ($cart === null) {
            $cart = new Cart($customer);

            $this->repository->create($cart);
        }

        return $cart;
    }
}