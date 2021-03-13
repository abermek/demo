<?php

namespace Tests\Acceptance\Cart;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class PutCest
{
    public function putProductToTheCart(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([
            'product'   => 'sword',
            'quantity'  => 1
        ]);
        $I->seeResponseContainsJson([
            'items' => [
                [
                    'name'  => 'Sword',
                    'price' => '$1.00',
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
            'product'   => 'sword',
            'quantity'  => 1
        ]);
        $I->putToCart([
            'product'   => 'sword',
            'quantity'  => 2
        ]);
        $I->seeResponseContainsJson([
            'items' => [
                'name'  => 'Sword',
                'price' => '$1.00',
                'quantity' => 3,
                'total' => '$3.00'
            ],
            'total' => '$3.00'
        ]);
    }

    public function putProductThatDoesNotExists(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([
            'product'   => 'magic-sword-99',
            'quantity'  => 1
        ]);
        $I->seeBadRequest(
            ['path' => 'product', 'description' => 'The selected Product does not exist']
        );
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function putProductWithRequiredParametersMissing(AcceptanceTester $I)
    {
        $I->amJack();
        $I->putToCart([]);
        $I->seeBadRequest([
            ['path' => 'product', 'description' => 'This value should not be null.'],
            ['path' => 'quantity', 'description' => 'This value should not be null.'],
        ]);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
