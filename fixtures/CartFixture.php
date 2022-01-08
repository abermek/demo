<?php

namespace Fixture;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Fixture\Security\UserFixture;

class CartFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
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
                'customer' => 'john',
                'items'    => [
                    [
                        'product'  => 'Staff',
                        'quantity' => 1
                    ]
                ]
            ],
            [
                'customer' => 'jane',
                'items'    => [
                    [
                        'product'  => 'Sword',
                        'quantity' => 10
                    ]
                ]
            ]
        ];

        foreach ($carts as $prop) {
            /** @var User $customer */
            $customer = $this->getReference($prop['customer']);
            $cart = new Cart($customer);

            foreach ($prop['items'] as $row) {
                /** @var Product $product */
                $product = $this->getReference($row['product']);
                $item = new CartItem();
                $item
                    ->setCart($cart)
                    ->setProduct($product)
                    ->setQuantity($row['quantity']);

                $cart->getItems()->add($item);
            }

            $manager->persist($cart);
        }

        $manager->flush();
    }
}
