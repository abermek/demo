<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Symfony\Component\Security\Core\Security;

class GetActiveCart
{
    private Security $security;
    private GetCustomerCart $getCustomerCart;

    public function __construct(Security $security, GetCustomerCart $getCustomerCart)
    {
        $this->security = $security;
        $this->getCustomerCart = $getCustomerCart;
    }

    public function execute(): Cart
    {
        /** @var User $customer */
        $customer = $this->security->getUser();

        return $this->getCustomerCart->execute($customer);
    }
}
