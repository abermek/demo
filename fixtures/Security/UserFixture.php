<?php

namespace Fixture\Security;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::getPlayers() as $username) {
            $player = $this->createPlayer($username);

            $manager->persist($player);

            $this->addReference($username, $player);
        }

        $manager->flush();
    }

    public function createPlayer(string $username): User
    {
        $password = '1';
        $player = new User();

        $player->setUsername($username);
        $player->setSalt($password);
        $player->setPassword(
            $this->passwordEncoder->encodePassword($player, $password)
        );

        return $player;
    }

    function getDependencies()
    {
        return [
            ClientFixture::class
        ];
    }

    public static function getPlayers(): array
    {
        return [
            'john',
            'jane',
            'jack',
        ];
    }
}
