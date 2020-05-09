<?php

namespace Fixture\Security;

use App\Entity\Security\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixture extends Fixture
{
    public function createClient(string $identity): Client
    {
        $client = new Client();

        $client->setRandomId($identity);
        $client->setSecret($identity);
        $client->setAllowedGrantTypes(['password', 'authorization_code']);

        return $client;
    }

    public function load(ObjectManager $manager)
    {
        $fixtures = [
            'acme'
        ];

        foreach ($fixtures as $identity) {
            $client = $this->createClient($identity);

            $manager->persist($client);

            $this->addReference($identity, $client);
        }

        $manager->flush();
    }
}
