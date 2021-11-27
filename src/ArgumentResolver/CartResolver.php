<?php

namespace App\ArgumentResolver;

use App\Entity\Cart;
use App\Service\Cart\GetActualCart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CartResolver implements ArgumentValueResolverInterface
{
    public function __construct(private GetActualCart $getActualCart)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === Cart::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->getActualCart->execute();
    }
}
