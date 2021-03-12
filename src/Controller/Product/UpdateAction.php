<?php

namespace App\Controller\Product;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\Product;
use App\Form\Type\Product\ProductType;
use App\Security\Voter\ProductVoter;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(ProductVoter::PERMISSION_UPDATE, subject="product")
 *
 * @OA\RequestBody(request=ProductType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Returns updated Product",
 *     @SWG\Model(type=Product::class)
 * )
 * @OA\Tag(name="Product")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/products/{id}', name: 'products.update', requirements: ['id' => '^[1-9]\d*$'], methods: ['POST'])]
class UpdateAction
{
    use FormFactoryTrait;
    use EntityManagerTrait;

    public function __invoke(Product $product, Request $request)
    {
        $form = $this->formFactory->create(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $this->em->flush();
        $this->em->refresh($product);

        return $product;
    }
}
