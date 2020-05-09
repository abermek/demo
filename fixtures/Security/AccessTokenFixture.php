<?php

namespace Fixture\Security;

use App\Entity\Security\AccessToken;
use App\Entity\Security\Client;
use App\Entity\Security\User;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccessTokenFixture extends Fixture implements DependentFixtureInterface
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /** @var Client $client */
        $client = $this->getReference('acme');

        foreach (UserFixture::getPlayers() as $username) {
            /** @var User $player */
            $player = $this->getReference($username);
            $token  = $this->createAccessToken($username, $player, $client);

            $manager->persist($token);
        }

        $manager->flush();
    }

    public function createAccessToken(string $token, User $user, Client $client): AccessToken
    {
        $expireAt = (new DateTime())->add(new DateInterval("P365D"));

        $accessToken = new AccessToken();
        $accessToken->setToken($token);
        $accessToken->setUser($user);
        $accessToken->setClient($client);
        $accessToken->setExpiresAt($expireAt->getTimestamp());

        return $accessToken;
    }

    function getDependencies()
    {
        return [
            ClientFixture::class,
            UserFixture::class
        ];
    }
}
