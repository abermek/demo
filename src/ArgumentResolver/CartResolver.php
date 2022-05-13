<?php

namespace App\ArgumentResolver;

use App\Entity\Cart;
use App\Entity\Security\User;
use App\Exception\NotImplementedException;
use App\Service\Cart\FindOrCreate;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;

class CartResolver implements ArgumentValueResolverInterface
{
    public function __construct(private readonly FindOrCreate $getActualCart, private readonly Security $security)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Cart::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if ($user === null) {
            throw new NotImplementedException('Guests are not implemented');
        }

        yield $this->getActualCart->execute($user);
    }
}
