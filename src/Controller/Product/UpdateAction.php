<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Exception\Input\InvalidInputException;
use App\Form\Type\Product\ProductType;
use App\Security\Voter\ProductVoter;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @ParamConverter("product", class=Product::class)
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
    public function __invoke(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory
    ): Product {
        $form = $formFactory->create(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            throw new InvalidInputException($form);
        }

        $em->flush();
        $em->refresh($product);

        return $product;
    }
}
