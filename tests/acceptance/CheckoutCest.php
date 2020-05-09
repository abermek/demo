<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class CheckoutCest
{
    public function iSeeProductsQuantitySubtotalsAndGrandTotalAtTheCheckout(AcceptanceTester $I)
    {
        $I->amJack();

        $I->amAtCheckout();
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->putToCart([
            'product'   => 1,
            'quantity'  => 2
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->putToCart([
            'product'   => 2,
            'quantity'  => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->amAtCheckout();
        $I->seeResponseContainsJson([
            'items' => [
                [
                    'product' => [
                        'name'      => 'Staff',
                        'price'     => '$10.00'
                    ],
                    'quantity'  => 1,
                    'total'     => '$10.00'
                ],
                [
                    'product' => [
                        'name'      => 'Sword',
                        'price'     => '$1.00'
                    ],
                    'quantity'  => 2,
                    'total'     => '$2.00'
                ]
            ],
            'total' => '$12.00'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}