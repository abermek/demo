<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\Security\User;
use Symfony\Component\Security\Core\Security;

class GetActiveCart
{
    public function __construct(private Security $security, private GetCustomerCart $getCustomerCart)
    {
    }

    public function execute(): Cart
    {
        /** @var User $customer */
        $customer = $this->security->getUser();

        return $this->getCustomerCart->execute($customer);
    }
}
