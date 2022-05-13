<?php

namespace App\Tests\Controller\Product;

use App\Test\Actor;
use App\Test\Money;
use App\Test\Schema;
use App\Tests\Controller\ActionTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class CreateActionTest extends ActionTestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(array $parameters, Schema $schema, int $statusCode, array $constraints): void
    {
        $makeRequest = function (KernelBrowser $browser) use ($parameters) {
            $browser->loginUser(Actor::john(static::getContainer()));
            $browser->request('POST', '/v1/products', $parameters);
        };

        $this->assertActionResponse($makeRequest, $statusCode, $schema, $constraints);
    }

    public function dataProvider(): array
    {
        return [
            [
                'parameters' => [
                    'name' => 'A bow',
                    'price' => Money::USD(10.00)
                ],
                'schema' => new Schema\Product(),
                'statusCode' => 200,
                'constraints' => [
                    '$.name' => 'A bow',
                    '$.price.amount' => 10.00,
                    '$.price.currency' => 'USD'
                ]
            ],
            [
                'parameters' => [
                    'price' => Money::USD(10.00)
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'name',
                    '$.errors[0].description' => 'This value should not be blank.'
                ]
            ],
            [
                'parameters' => [
                    'name' => 'A bow'
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'price',
                    '$.errors[0].description' => 'This value should not be null.'
                ]
            ],
            [
                'parameters' => [
                    'name' => 'A bow',
                    'price' => Money::USD(0.00)
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'price',
                    '$.errors[0].description' => 'This value should be greater than 0.'
                ]
            ],
            [
                'parameters' => [
                    'name' => '<b>A bow</b>',
                    'price' => Money::USD(10.00)
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'name',
                    '$.errors[0].description' => 'This value is not valid.'
                ]
            ],
            [
                'parameters' => [
                    'name' => join('', array_fill(0, 300, 'a')),
                    'price' => Money::USD(10.00)
                ],
                'schema' => new Schema\BadRequest(),
                'statusCode' => 400,
                'constraints' => [
                    '$.errors[0].path' => 'name',
                    '$.errors[0].description' => 'This value is too long. It should have 200 characters or less.'
                ]
            ]
        ];
    }
}
