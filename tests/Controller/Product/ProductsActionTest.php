<?php

namespace App\Tests\Controller\Product;

use App\Test\Actor;
use App\Test\Schema\Product\Products;
use App\Tests\Controller\ActionTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ProductsActionTest extends ActionTestCase
{
    private const ROUTING = ['read' => '/v1/products'];

    public function testProducts(): void
    {
        $makeRequest = function (KernelBrowser $browser) {
            $browser->loginUser(Actor::john(static::getContainer()));
            $browser->request('GET', self::ROUTING['read']);
        };

        $this->assertActionResponse($makeRequest, 200, new Products(), []);
    }
}
