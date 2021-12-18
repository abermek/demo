<?php declare(strict_types=1);

namespace Fixture;

use App\Entity\Product;
use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Fixture\Security\UserFixture;
use Money\Money;

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
                'slug'  => 'sword',
                'name'  => 'Sword',
                'owner' => 'john',
                'price' => 100
            ],
            [
                'slug'  => 'staff',
                'name'  => 'Staff',
                'owner' => 'jane',
                'price' => 1000
            ],
            [
                'slug'  => 'wooden-shield',
                'name'  => 'Shield',
                'owner' => 'john',
                'price' => 100
            ],
        ];

        foreach ($products as $props) {
            /** @var User $owner */
            $owner = $this->getReference($props['owner']);

            $product = new Product();
            $product
                ->setOwner($owner)
                ->setSlug($props['slug'])
                ->setPrice(Money::USD($props['price']))
                ->setName($props['name']);

            $this->setId($product);

            $this->addReference($props['name'], $product);

            $manager->persist($product);
        }

        $this->explicitIdentity($manager, Product::class);

        $manager->flush();
    }
}
