<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\DTO\Response\BadRequest\InvalidPageResponse;
use App\DTO\Response\PaginationResponse;
use App\Entity\Product;
use App\DTO\Product\ProductCriteria;
use App\Entity\Security\User;
use App\Repository\ProductRepositoryInterface;
use App\Traits\EntityManagerTrait;
use App\Traits\FormFactoryTrait;
use FOS\RestBundle\View\View;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Voter\ProductVoter;
use App\Form\Type\Product\ProductCriteriaType;
use App\Form\Type\Product\ProductType;
use Symfony\Component\Security\Core\User\UserInterface;

/** @Route("/products", name="products_") */
class ProductController
{
    use FormFactoryTrait;
    use EntityManagerTrait;

    private const PRODUCTS_PER_PAGE = 20;

    /**
     * @Route("/{page}", name="index", methods={"GET"}, requirements={"page"="^[1-9]\d*$"}, defaults={"page"=1})
     */
    public function index(ProductRepositoryInterface $repository, Request $request, int $page = 1)
    {
        $criteria = new ProductCriteria();
        $form = $this->formFactory->create(ProductCriteriaType::class, $criteria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        try {
            return new PaginationResponse(
                $repository->paginate($criteria, $page, self::PRODUCTS_PER_PAGE)
            );
        } catch (OutOfRangeCurrentPageException $e) {
            return View::create(new InvalidPageResponse($page), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("", name="create", methods={"POST"})
     * @IsGranted(ProductVoter::PERMISSION_CREATE)
     */
    public function create(Request $request, UserInterface $owner)
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

    /**
     * @Route("/{id}", name="update", methods={"POST"}, requirements={"id"="^[1-9]\d*$"})
     * @IsGranted(ProductVoter::PERMISSION_UPDATE, subject="product")
     */
    public function update(Product $product, Request $request)
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

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id"="^[1-9]\d*$"})
     * @IsGranted(ProductVoter::PERMISSION_DELETE, subject="product")
     */
    public function delete(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
