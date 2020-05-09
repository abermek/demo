<?php
namespace App\Tests;

use Codeception\Actor;
use Codeception\Util\HttpCode;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    public function amJohn()
    {
        $this->amBearerAuthenticated('john');
    }

    public function amJane()
    {
        $this->amBearerAuthenticated('jane');
    }

    public function amJack()
    {
        $this->amBearerAuthenticated('jack');
    }

    public function seeSuccessfulResponse(array $response = [])
    {
        $this->seeResponseCodeIs(HttpCode::OK);
        $this->seeResponseIsJson();

        if (!empty($response)) {
            $this->seeResponseContainsJson($response);
        }
    }

    public function listProducts(int $page = null)
    {
        $url = '/v1/products';

        if (!empty($page)) {
            $url .= "/{$page}";
        }

        $this->sendGET($url);
    }

    public function updateProduct(int $id, array $product)
    {
        $this->sendPOST('/v1/products/' . $id, $product);
    }

    public function createProduct(array $product)
    {
        $this->sendPOST('/v1/products', $product);
    }

    public function deleteProduct(int $id)
    {
        $this->sendDELETE('/v1/products/' . $id);
    }

    public function putToCart(array $purchase)
    {
        $this->sendPOST('/v1/cart', $purchase);
    }

    public function seeBadRequest(array $errors = [])
    {
        if (!empty($errors)) {
            $this->seeResponseContainsJson(['errors' => $errors]);
        }

        $this->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function amAtCheckout()
    {
        $this->sendGET('/v1/checkout');
    }
}
