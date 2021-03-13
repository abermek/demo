<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Security\Voter\ProductVoter;
use App\Traits\EntityManagerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @ParamConverter("product", class=Product::class)
 * @IsGranted(ProductVoter::PERMISSION_DELETE, subject="product")
 *
 * @OA\Response(response=204,description="No Content")
 * @OA\Tag(name="Product")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/products/{id}', name: 'products.delete', requirements: ['id' => '^[1-9]\d*$'], methods: ['DELETE'])]
class DeleteAction
{
    public function __invoke(EntityManagerInterface $em, Product $product): void
    {
        $em->remove($product);
        $em->flush();
    }
}
