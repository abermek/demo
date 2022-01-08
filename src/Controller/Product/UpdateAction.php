<?php

namespace App\Controller\Product;

use App\Attribute\Input;
use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Security\Voter\ProductVoter;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
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
#[Route(path: '/products/{id}', name: 'products.update', requirements: ['id' => '^[1-9]\d*$'], methods: ['PUT', 'PATCH'])]
class UpdateAction
{
    public function __invoke(
        #[Input(formClass: ProductType::class, identity: "id")] Product $product,
        Request $request,
        EntityManagerInterface $em
    ): Product {
        $em->flush();
        $em->refresh($product);

        return $product;
    }
}
