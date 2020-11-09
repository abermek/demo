<?php

namespace App\Controller\Product;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\Product;
use App\Form\Type\Product\ProductType;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Voter\ProductVoter;

/**
 * @Route("/products/{id}", name="products.update", methods={"POST"}, requirements={"id"="^[1-9]\d*$"})
 * @IsGranted(ProductVoter::PERMISSION_UPDATE, subject="product")
 */
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
