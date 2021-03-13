<?php

namespace Tests\Acceptance\Cart;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class GetCest
{
    public function iSeeProductsQuantitySubtotalsAndGrandTotalInMyCart(AcceptanceTester $I)
    {
        $I->amJack();

        $I->getCart();
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->putToCart([
            'product'   => 'sword',
            'quantity'  => 2
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->putToCart([
            'product'   => 'staff',
            'quantity'  => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->getCart();
        $I->seeResponseContainsJson([
            'items' => [
                [
                    'name'      => 'Sword',
                    'quantity'  => 2,
                    'total'     => '$2.00',
                    'price'     => '$1.00'
                ],
                [
                    'name'      => 'Staff',
                    'quantity'  => 1,
                    'total'     => '$10.00',
                    'price'     => '$10.00'
                ]
            ],
            'total' => '$12.00'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
