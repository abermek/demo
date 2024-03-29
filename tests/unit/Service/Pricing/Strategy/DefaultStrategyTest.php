<?php

namespace Tests\Unit\Service\Pricing\Strategy;

use App\Entity\Cart\Item;
use App\Entity\Product;
use App\DTO\Receipt;
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
            $product->name = $purchase['name'];
            $product->price = $purchase['price'];

            $cartItem = new Item();
            $cartItem->product = $product;
            $cartItem->quantity = $purchase['quantity'];

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
