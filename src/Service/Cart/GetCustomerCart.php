<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;

class GetCustomerCart
{
    public function execute(User $customer): Cart
    {
        $cart = $customer->getCart();

        if (is_null($cart)) {
            $cart = new Cart($customer);
        }

        return $cart;
    }
}
