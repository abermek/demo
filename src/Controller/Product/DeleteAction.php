<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Traits\EntityManagerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Voter\ProductVoter;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation as SWG;

/**
 * @IsGranted(ProductVoter::PERMISSION_DELETE, subject="product")
 *
 * @OA\Response(response=204,description="No Content")
 * @OA\Tag(name="Product")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/products/{id}', name: 'products.delete', requirements: ['id' => '^[1-9]\d*$'], methods: ['DELETE'])]
class DeleteAction
{
    use EntityManagerTrait;

    public function __invoke(Product $product)
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
