<?php

namespace App\Controller\Cart;

use App\DTO\Purchase;
use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Form\Type\PurchaseType;
use App\Service\Cart\ActiveCart;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Pricing\Receipt;

/**
 * @OA\RequestBody(request=PurchaseType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Put Product To The Cart",
 *     @SWG\Model(type=Receipt::class)
 * )
 * @OA\Tag(name="Cart")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/cart', name: 'cart.put', methods: ['POST'])]
class PostAction
{
    use EntityManagerTrait;
    use FormFactoryTrait;

    public function __construct(private ActiveCart $cart)
    {
    }

    public function __invoke(Request $request)
    {
        $purchase = new Purchase();
        $form = $this->formFactory->create(PurchaseType::class, $purchase);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $this->cart->addPurchase($purchase);

        $this->em->flush();

        return $this->cart->getReceipt();
    }
}
