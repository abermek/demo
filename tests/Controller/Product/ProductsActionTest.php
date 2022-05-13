<?php

namespace App\Tests\Controller\Product;

use App\Test\Actor;
use App\Test\Schema\Product\Products;
use App\Tests\Controller\ActionTestCase;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ProductsActionTest extends ActionTestCase
{
    /** @dataProvider dataProvider */
    public function testProducts(string $username, array $parameters, array $constraints): void
    {
        $makeRequest = function (KernelBrowser $browser) use ($username, $parameters) {
            $browser->loginUser(Actor::as($username, static::getContainer()));
            $browser->request('GET', '/v1/products', $parameters);
        };

        $this->assertActionResponse($makeRequest, 200, new Products(), $constraints);
    }

    public function dataProvider(): array
    {
        return [
            [
                'user' => Actor::JACK,
                'parameters' => [
                    'page' => 1,
                    'limit' => 1
                ],
                'constraints' => [
                    '$.items' => new Count(1),
                    '$.items[0].name' => 'Sword'
                ]
            ],
            [
                'user' => Actor::JACK,
                'parameters' => [
                    'page' => 3,
                    'limit' => 1
                ],
                'constraints' => [
                    '$.items' => new Count(1),
                    '$.items[0].name' => 'Staff'
                ]
            ]
        ];
    }
}
