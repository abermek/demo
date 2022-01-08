<?php

namespace App\Controller\Product;

use App\Attribute\Input;
use App\Entity\Product;
use App\Entity\Security\User;
use App\Form\Type\ProductType;
use App\Security\Voter\ProductVoter;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * @IsGranted(ProductVoter::PERMISSION_CREATE)
 *
 * @OA\RequestBody(request=ProductType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Returns created Product",
 *     @SWG\Model(type=Product::class)
 * )
 * @OA\Tag(name="Product")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/products', name: 'products.create', methods: ['POST'])]
class CreateAction
{
    public function __invoke(
        EntityManagerInterface $em,
        #[CurrentUser] User $owner,
        #[Input(ProductType::class, ['Default', 'Create'])] Product $product
    ): Product {
        $product->setOwner($owner);

        $em->persist($product);
        $em->flush();
        $em->refresh($product);

        return $product;
    }
}
