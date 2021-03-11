<?php

namespace App\Controller\Product;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Entity\Product;
use App\Entity\Security\User;
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
use Symfony\Component\Security\Core\User\UserInterface;

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
