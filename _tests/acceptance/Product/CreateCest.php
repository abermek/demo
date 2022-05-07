<?php

namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class CreateCest
{
    public function createProduct(AcceptanceTester $I)
    {
        $product = [
            'name' => 'Long Sword +5',
            'price' => $I->usd(),
        ];

        $I->amJohn();
        $I->createProduct($product);
        $I->seeResponseContainsJson($product);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function withMissingName(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct(['price' => $I->usd()]);
        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value should not be blank.']
        );
    }

    public function withBlankName(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct(['name' => '', 'price' => $I->usd()]);
        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value should not be blank.']
        );
    }

    public function withMissingPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct(['name' => 'Long Sword']);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'This value should not be null.']
        );
    }

    public function withZeroPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct(['name' => 'Long Sword', 'price' => $I->usd(0)]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'This value should be greater than 0.']
        );
    }

    public function withNameContainsForbiddenCharacters(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct(['name' => '<b>Long sword +5</b>!!!!!', 'price' => $I->usd()]);

        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value is not valid.']
        );
    }
}
