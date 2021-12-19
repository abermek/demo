<?php

namespace Tests\Unit\Service\Pricing\Strategy;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Pricing\Receipt;
use App\Service\Pricing\Strategy\DefaultStrategy;
use Codeception\Test\Unit;
use Money\Money;

class DefaultStrategyTest extends Unit
{
    public function getSystemUnderTest(): DefaultStrategy
    {
        return new DefaultStrategy();
    }

    /** @dataProvider executeDataProvider */
    public function testExecute(array $purchases, Money $total): void
    {
        $cartItems = [];

        foreach ($purchases as $purchase) {
            $product = new Product();
            $product->setId($purchase['id']);
            $product->setName($purchase['name']);
            $product->setPrice($purchase['price']);

            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity($purchase['quantity']);

            $cartItems[] = $cartItem;
        }

        $receipt = $this->getSystemUnderTest()->execute(...$cartItems);

        self::assertInstanceOf(Receipt::class, $receipt);
        self::assertTrue($total->equals($receipt->getTotal()));
    }

    protected function executeDataProvider(): array
    {
        return [
            [
                'purchases' => [
                    [
                        'id' => 1,
                        'name' => 'sword',
                        'price' => Money::USD(1),
                        'quantity' => 1
                    ]
                ],
                'total' => Money::USD(1)
            ],
            [
                'purchases' => [
                    [
                        'id' => 1,
                        'name' => 'sword',
                        'price' => Money::USD(1),
                        'quantity' => 1
                    ],
                    [
                        'id' => 2,
                        'name' => 'shield',
                        'price' => Money::USD(5),
                        'quantity' => 2
                    ]
                ],
                'total' => Money::USD(11)
            ]
        ];
    }
}
