<?php

namespace Fixture\Security;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
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

            $user->setUsername($username);
            $user->setSalt($password);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

            $manager->persist($user);

            $this->addReference($username, $user);
        }

        $manager->flush();
    }
}
