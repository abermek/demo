<?php
namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class CreateCest
{
    public function createProduct(AcceptanceTester $I)
    {
        $product = [
            'name'  => 'Long Sword +5',
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
            'name'  => 'Long Sword'
        ]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'This value should not be null.']
        );
    }

    public function withZeroPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'name'  => 'Long Sword',
            'price' => 0
        ]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'The given "0" value is not valid.']
        );
    }

    public function withNameContainsForbiddenCharacters(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->createProduct([
            'name'  => '<b>Long sword +5</b>!!!!!',
            'price' => 1000
        ]);

        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value is not valid.']
        );
    }
}
