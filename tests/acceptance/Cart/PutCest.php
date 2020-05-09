<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class PutCest
{
    public function putProductToTheCart(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([
            'product'   => 1,
            'quantity'  => 1
        ]);
        $I->seeResponseContainsJson([
            'items' => [
                [
                    'product'  => [
                        'id'    => 1,
                        'name'  => 'Sword',
                        'price' => '$1.00'
                    ],
                    'quantity' => 1
                ]
            ]
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function putProductThatAlreadyIsInTheCart(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([
            'product'   => 1,
            'quantity'  => 1
        ]);
        $I->putToCart([
            'product'   => 1,
            'quantity'  => 2
        ]);
        $I->seeResponseContainsJson([
            'items' => [
                'product'  => [
                    'id'    => 1,
                    'name'  => 'Sword',
                    'price' => '$1.00'
                ],
                'quantity' => 3
            ]
        ]);
    }

    public function putProductThatDoesNotExists(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([
            'product'   => 99999,
            'quantity'  => 1
        ]);
        $I->seeBadRequest(
            ['path' => 'product', 'description' => 'This value is not valid.']
        );
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function putProductWithRequiredParametersMissing(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([]);
        $I->seeBadRequest(
            ['path' => 'product', 'description' => 'This value should not be null.'],
            ['path' => 'quantity', 'description' => 'This value should not be null.'],
        );
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}