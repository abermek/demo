<?php

namespace Tests\Acceptance\Product;

use App\Tests\AcceptanceTester;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $I->expectThrowable(NotFoundHttpException::class, fn() => $I->deleteProduct(999999));

    }

    public function deleteProductThatDoesNotBelongsToMe(AcceptanceTester $I)
    {
        $I->amJane();
        $I->expectThrowable(AccessDeniedHttpException::class, fn() => $I->deleteProduct(self::PRODUCT_ID));
    }

}