<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Security\Voter\ProductVoter;
use App\Traits\EntityManagerTrait;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

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
