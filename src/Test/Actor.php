<?php

namespace App\Test;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Actor
{
    public const JACK = 'jack';
    public const JOHN = 'john';

    public static function john(ContainerInterface $container): User
    {
        return self::as(self::JOHN, $container);
    }

    public static function jack(ContainerInterface $container): User
    {
        return self::as(self::JACK, $container);
    }

    public static function as(string $username, ContainerInterface $container): User
    {
        $user = $container
            ->get(EntityManagerInterface::class)
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);

        if (empty($user)) {
            throw new AssertionFailedError("User '$username' was not found");
        }

        return $user;
    }
}
