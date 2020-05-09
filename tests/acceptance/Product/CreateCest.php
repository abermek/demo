<?php
namespace App\Tests;

use Codeception\Util\HttpCode;

class CreateCest
{
    public function createProduct(AcceptanceTester $I)
    {
        $product = [
            'name'  => 'The Legendary',
            'price' => 1000
        ];

        $I->amJohn();
        $I->createProduct($product);
        $I->seeResponseContainsJson([
            'name'  => $product['name'],
            'price' => '$10.00'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function withMissingName(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'price' => 1000
        ]);
        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value should not be blank.']
        );
    }

    public function withBlankName(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'name'  => '',
            'price' => 1000
        ]);
        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value should not be blank.']
        );
    }

    public function withMissingPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'name'  => 'The Legendary'
        ]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'This value should not be null.']
        );
    }

    public function withZeroPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'name'  => 'The Legendary',
            'price' => 0
        ]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'The given "0" value is not valid.']
        );
    }
}
