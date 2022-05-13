<?php

namespace App\Tests\Controller\Cart;

use App\Test\Actor;
use App\Test\Schema\Cart;
use App\Tests\Controller\ActionTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class GetActionTest extends ActionTestCase
{
    public function testGet(): void
    {
        $makeRequest = function (KernelBrowser $browser) {
            $browser->loginUser(Actor::jack(static::getContainer()));
            $browser->request('GET', '/v1/cart');
        };

        $constraints = [
            '$.items[0].name' => 'Sword',
            '$.items[0].quantity' => 2,
            '$.items[0].total.amount' => 2.00,
            '$.items[0].total.currency' => 'USD',
            '$.items[0].price.amount' => 1.00,
            '$.items[0].price.currency' => 'USD',
            '$.items[1].name' => 'Staff',
            '$.items[1].quantity' => 1,
            '$.items[1].total.amount' => 10.00,
            '$.items[1].total.currency' => 'USD',
            '$.items[1].price.amount' => 10.00,
            '$.items[1].price.currency' => 'USD',
        ];

        $this->assertActionResponse($makeRequest, 200, new Cart(), $constraints);
    }
}
