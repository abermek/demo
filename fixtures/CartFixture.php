<?php

namespace Fixture;

use App\Entity\Cart;
use App\Entity\Cart\Item;
use App\Entity\Product;
use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Fixture\Security\UserFixture;

class CartFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            ProductFixture::class
        ];
    }

    public function load(ObjectManager $manager)
    {
        $carts = [
            [
                'customer' => 'jack',
                'items' => [
                    [
                        'product' => 'Sword',
                        'quantity' => 2
                    ],
                    [
                        'product' => 'Staff',
                        'quantity' => 1
                    ]
                ]
            ]
        ];

        foreach ($carts as $prop) {
            /** @var User $user */
            $user = $this->getReference($prop['customer']);

            $cart = new Cart();
            $cart->owner = $user;

            foreach ($prop['items'] as $row) {
                /** @var Product $product */
                $product = $this->getReference($row['product']);
                $item = new Item();
                $item->cart = $cart;
                $item->product = $product;
                $item->quantity = $row['quantity'];

                $cart->items->add($item);
            }

            $manager->persist($cart);
        }

        $manager->flush();
    }
}
