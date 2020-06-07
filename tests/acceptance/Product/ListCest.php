<?php

namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class ListCest
{
    public function listProducts(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->listProducts();
        $I->seeResponseContainsJson([
            'items' => [
                [
                    "id"    => 1,
                    "name"  => "Sword",
                    "price" => "$1.00",
                ],
                [
                    "id"    => 2,
                    "name"  => "Staff",
                    "price" => "$10.00",
                ],
                [
                    "id"    => 3,
                    "name"  => "Shield",
                    "price" => "$1.00",
                ]
            ],
            'page'  => 1,
            'total' => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function listProductsWithPageThatDoesNotExists(AcceptanceTester $I)
    {
        $page = 9999;

        $I->amJohn();
        $I->listProducts($page);
        $I->seeBadRequest(['description' => "Page #{$page} does not exists"]);
    }
}
