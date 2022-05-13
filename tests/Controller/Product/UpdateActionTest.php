<?php

namespace App\Tests\Controller\Product;

use App\Test\Actor;
use App\Test\Money;
use App\Test\Schema;
use App\Tests\Controller\ActionTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class UpdateActionTest extends ActionTestCase
{
    /** @dataProvider dataProvider */
    public function testUpdate(
        string $username,
        array $parameters,
        int $statusCode = 200,
        Schema $schema = null,
        array $constraints = []
    ): void {
        $makeRequest = function (KernelBrowser $browser) use ($parameters, $username) {
            $browser->loginUser(Actor::as($username, static::getContainer()));
            $browser->request('PATCH', '/v1/products/1', $parameters);
        };

        $this->assertActionResponse($makeRequest, $statusCode, $schema, $constraints);
    }

    public function testForbidden(): void
    {
        $browser = static::createClient();

        $browser->loginUser(Actor::jack(static::getContainer()));
        $browser->request('PATCH', '/v1/products/1');

        self::assertResponseStatusCodeSame(403);
    }

    public function dataProvider(): array
    {
        return [
            [
                'username' => Actor::JOHN,
                'parameters' => [
                    'name' => 'A bow',
                    'price' => Money::USD(9.99)
                ],
                'statusCode' => 200,
                'schema' => new Schema\Product(),
                'constraints' => [
                    '$.name' => 'A bow',
                    '$.price.amount' => 9.99,
                    '$.price.currency' => 'USD'
                ]
            ]
        ];
    }
}
