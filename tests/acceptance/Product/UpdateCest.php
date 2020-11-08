<?php
namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class UpdateCest
{
    const PRODUCT_ID = 1;

    public function updateProduct(AcceptanceTester $I)
    {
        $product = [
            'name'  => 'My Product #1',
            'price' => 1000
        ];

        $I->amJohn();
        $I->updateProduct(self::PRODUCT_ID, $product);
        $I->seeResponseContainsJson([
            'name'  => $product['name'],
            'price' => '$10.00'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function withZeroPrice(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->updateProduct(self::PRODUCT_ID, ['price' => 0]);
        $I->seeBadRequest(
            ['path' => 'price', 'description' => 'The given "0" value is not valid.']
        );
    }

    public function withTooLongName(AcceptanceTester $I)
    {
        $name = join('', array_fill(0, 300, 'a'));

        $I->amJohn();
        $I->updateProduct(self::PRODUCT_ID, ['name' => $name]);
        $I->seeBadRequest(
            ['path' => 'name', 'description' => 'This value is too long. It should have 255 characters or less.']
        );
    }

    public function updateProductThatDoesNotBelongsToMe(AcceptanceTester $I)
    {
        $I->amJane();
        $I->updateProduct(self::PRODUCT_ID, ['name' => 'My Product']);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
