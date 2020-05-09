<?php declare(strict_types=1);

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

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /** @inheritDoc */
    protected function supports($attribute, $subject)
    {
        if ($attribute === self::PERMISSION_CREATE) {
            return true;
        }

        $permissions = [
            self::PERMISSION_UPDATE,
            self::PERMISSION_DELETE,
        ];

        return $subject instanceof Product && in_array($attribute, $permissions);
    }

    /** @inheritDoc */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::PERMISSION_DELETE:
            case self::PERMISSION_UPDATE:
                return $subject->getOwner() === $user || $this->security->isGranted('ROLE_ADMIN');
            case self::PERMISSION_CREATE:
                return true;
            default:
                throw new LogicException('A voter for the ' . $attribute . ' was not found');
        }
    }
}
