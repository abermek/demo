<?php

namespace App\Tests\Service\Pricing\Strategy;

use App\DTO\Receipt;
use App\Entity\Cart;
use App\Entity\Cart\Item;
use App\Entity\Product;
use App\Service\Pricing\Strategy\DefaultStrategy;
use Money\Money;
use PHPUnit\Framework\TestCase;

class DefaultStrategyTest extends TestCase
{
    /** @dataProvider executeDataProvider */
    public function testExecute(array $purchases, Money $total): void
    {
        $cart = new Cart();

        foreach ($purchases as $purchase) {
            $product = new Product();
            $product->name = $purchase['name'];
            $product->price = $purchase['price'];

            $cartItem = new Item();
            $cartItem->product = $product;
            $cartItem->quantity = $purchase['quantity'];

            $cart->items->add($cartItem);
        }

        $receipt = (new DefaultStrategy())->execute($cart);

        self::assertInstanceOf(Receipt::class, $receipt);
        self::assertTrue($total->equals($receipt->total));
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
