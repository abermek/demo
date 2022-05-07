<?php

namespace App\Test;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Actor
{
    public static function john(ContainerInterface $container): User
    {
        return self::getUserOrFail('john', $container);
    }

    public static function jack(ContainerInterface $container): User
    {
        return self::getUserOrFail('jack', $container);
    }

    private static function getUserOrFail(string $username, ContainerInterface $container): User
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
