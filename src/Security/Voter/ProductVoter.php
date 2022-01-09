<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Product;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    public const PERMISSION_UPDATE = 'product.update';
    public const PERMISSION_CREATE = 'product.create';
    public const PERMISSION_DELETE = 'product.delete';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, $subject): bool
    {
        if (self::PERMISSION_CREATE === $attribute) {
            return true;
        }

        $permissions = [
            self::PERMISSION_UPDATE,
            self::PERMISSION_DELETE,
        ];

        return $subject instanceof Product && in_array($attribute, $permissions);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Product $subject */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return match ($attribute) {
            self::PERMISSION_DELETE,
            self::PERMISSION_UPDATE => $subject->owner === $user || $this->security->isGranted('ROLE_ADMIN'),
            self::PERMISSION_CREATE => true,
            default => throw new LogicException('A voter for the ' . $attribute . ' was not found'),
        };
    }
}
