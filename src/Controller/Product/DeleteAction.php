<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Traits\EntityManagerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Voter\ProductVoter;

/**
 * @Route("/products/{id}", name="products.delete", methods={"DELETE"}, requirements={"id"="^[1-9]\d*$"})
 * @IsGranted(ProductVoter::PERMISSION_DELETE, subject="product")
 */
class DeleteAction
{
    use EntityManagerTrait;

    public function __invoke(Product $product)
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
