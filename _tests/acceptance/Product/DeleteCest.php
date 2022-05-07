<?php

namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

class DeleteCest
{
    const PRODUCT_ID = 1;

    public function deleteProduct(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->deleteProduct(self::PRODUCT_ID);
        $I->seeResponseCodeIsSuccessful();
    }

    public function deleteProductThatDoesNotExists(AcceptanceTester $I)
    {
        $I->amJohn();
        $I->deleteProduct(999999);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);

    }

    public function deleteProductThatDoesNotBelongsToMe(AcceptanceTester $I)
    {
        $I->amJane();
        $I->deleteProduct(self::PRODUCT_ID);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

}
