<?php

namespace App\Tests\Controller\Product;

use App\Test\Actor;
use App\Tests\Controller\ActionTestCase;

class DeleteActionTest extends ActionTestCase
{
    public function testDelete(): void
    {
        $browser = static::createClient();

        $browser->loginUser(Actor::john(static::getContainer()));
        $browser->request('DELETE', '/v1/products/1');

        self::assertResponseIsSuccessful();
    }

    public function testNotFound(): void
    {
        $browser = static::createClient();

        $browser->loginUser(Actor::jack(static::getContainer()));
        $browser->request('DELETE', '/v1/products/999999');

        self::assertResponseStatusCodeSame(404);
    }

    public function testForbidden(): void
    {
        $browser = static::createClient();

        $browser->loginUser(Actor::jack(static::getContainer()));
        $browser->request('DELETE', '/v1/products/1');

        self::assertResponseStatusCodeSame(403);
    }

}
