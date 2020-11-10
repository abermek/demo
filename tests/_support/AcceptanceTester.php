<?php
namespace App\Tests;

use App\Entity\Security\User;
use Codeception\Actor;
use Codeception\Util\HttpCode;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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
        $this->loggedInAs('john');
    }

    public function amJane()
    {
        $this->loggedInAs('jane');
    }

    public function amJack()
    {
        $this->loggedInAs('jack');
    }

    public function loggedInAs(string $username)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->grabService(EntityManagerInterface::class);
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!$user) {
            throw new Exception("I can't login as {$username} - he doesn't exists");
        }

        $token = $this->grabService('lexik_jwt_authentication.jwt_manager')->create($user);

        $this->amBearerAuthenticated($token);
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

    public function getCart()
    {
        $this->sendGET('/v1/cart');
    }

    public function seeBadRequest(array $errors = [])
    {
        if (!empty($errors)) {
            $this->seeResponseContainsJson(['errors' => $errors]);
        }

        $this->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
