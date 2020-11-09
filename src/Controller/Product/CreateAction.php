<?php

namespace App\Controller\Product;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\Product;
use App\Entity\Security\User;
use App\Form\Type\Product\ProductType;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Security\Voter\ProductVoter;

/**
 * @Route("/products", name="products.create", methods={"POST"})
 * @IsGranted(ProductVoter::PERMISSION_CREATE)
 */
class CreateAction
{
    use FormFactoryTrait;
    use EntityManagerTrait;

    public function __invoke(Request $request, UserInterface $owner)
    {
        /** @var User $owner */
        $product = new Product($owner);

        $options = ['validation_groups' => ['Create']];
        $form = $this->formFactory->create(ProductType::class, $product, $options);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($product);
        $this->em->flush();
        $this->em->refresh($product);

        return $product;
    }
}
