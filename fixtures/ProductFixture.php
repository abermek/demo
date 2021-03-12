<?php declare(strict_types=1);

namespace Fixture;

use App\Entity\Product;
use App\Entity\Security\User;
use App\Model\Money\USD;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Fixture\Security\UserFixture;

class ProductFixture extends Fixture implements DependentFixtureInterface
{
    use ExplicitIdentityTrait;

    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }

    public function load(ObjectManager $manager)
    {
        $products = [
            [
                'name'  => 'Sword',
                'owner' => 'john',
                'price' => 100
            ],
            [
                'name'  => 'Staff',
                'owner' => 'jane',
                'price' => 1000
            ],
            [
                'name'  => 'Shield',
                'owner' => 'john',
                'price' => 100
            ],
        ];

        foreach ($products as $props) {
            /** @var User $owner */
            $owner = $this->getReference($props['owner']);

            $product = new Product($owner);
            $product
                ->setPrice(new USD($props['price']))
                ->setName($props['name']);

            $this->setId($product);

            $this->addReference($props['name'], $product);

            $manager->persist($product);
        }

        $this->explicitIdentity($manager, Product::class);

        $manager->flush();
    }
}
