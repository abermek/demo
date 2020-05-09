<?php

namespace App\Service\ParamConverter;

use App\Cart\CartInterface;
use App\Entity\Security\User;
use App\Service\Cart\GetCustomerCart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CartConverter implements ParamConverterInterface
{
    private Security $security;
    private GetCustomerCart $getCart;

    public function __construct(Security $security, GetCustomerCart $getCart)
    {
        $this->security = $security;
        $this->getCart = $getCart;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        /** @var User $customer */
        $customer = $this->security->getUser();
        if ($customer === null) {
            return;
        }

        $cart = $this->getCart->execute($customer);

        $request->attributes->set($configuration->getName(), $cart);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === CartInterface::class;
    }
}
