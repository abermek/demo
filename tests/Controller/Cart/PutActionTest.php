<?php

namespace App\Tests\Controller\Cart;

use App\Test\Actor;
use App\Test\Money;
use App\Test\Schema;
use App\Test\Schema\Cart;
use App\Tests\Controller\ActionTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class PutActionTest extends ActionTestCase
{
    /** @dataProvider dataProvider */
    public function testPut(array $parameters, Schema $schema, int $statusCode, array $constraints): void
    {
        $makeRequest = function (KernelBrowser $browser) use ($parameters) {
            $browser->loginUser(Actor::john(static::getContainer()));
            $browser->request('POST', '/v1/cart', $parameters);
        };

        $this->assertActionResponse($makeRequest, $statusCode, $schema, $constraints);
    }

    public function dataProvider(): array
    {
        return [
            [
                'parameters' => [
                    'product' => 'sword',
                    'quantity' => 1
                ],
                'schema' => new Schema\Cart(),
                'statusCode' => 200,
                'constraints' => [
                    '$.items[0].name' => 'Sword',
                    '$.items[0].quantity' => 1,
                    '$.items[0].total.amount' => 1.00,
                    '$.items[0].total.currency' => 'USD',
                    '$.items[0].price.amount' => 1.00,
                    '$.items[0].price.currency' => 'USD',
                    '$.total.amount' => 1.00,
                    '$.total.currency' => 'USD',
                ]
            ],
            [
                'parameters' => [
                    'product' => 'sword-99999',
                    'quantity' => 1
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'product',
                    '$.errors[0].description' => 'The selected Product does not exist',
                ]
            ],
            [
                'parameters' => [],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'product',
                    '$.errors[0].description' => 'This value should not be null.',
                    '$.errors[1].path' => 'quantity',
                    '$.errors[1].description' => 'This value should not be null.',
                ]
            ]
        ];
    }
}
