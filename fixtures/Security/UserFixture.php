<?php

namespace Fixture\Security;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $password = 1;
        $users = [
            'john',
            'jane',
            'jack',
        ];

        foreach ($users as $username) {
            $user = new User();

            $user->username = $username;
            $user->salt = $password;
            $user->password = $this->passwordHasher->hashPassword($user, $password);

            $manager->persist($user);

            $this->addReference($username, $user);
        }

        $manager->flush();
    }
}
