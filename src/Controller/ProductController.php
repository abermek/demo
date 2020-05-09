<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\Page;
use App\DTO\Product\ProductDTO;
use App\DTO\View\ProductView;
use App\Entity\Product;
use App\DTO\Product\ProductCriteria;
use App\Entity\Security\User;
use App\Service\Product\CreateProduct;
use App\Service\Product\DeleteProduct;
use App\Service\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Voter\ProductVoter;
use App\Form\Type\Product\ProductCriteriaType;
use App\Form\Type\Product\ProductType;
use App\Service\Product\UpdateProduct;
use Symfony\Component\Security\Core\User\UserInterface;

/** @Route("/products", name="products_") */
class ProductController
{
    private const PRODUCTS_PER_PAGE = 20;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{page}", name="index", methods={"GET"}, requirements={"page"="^[1-9]\d*$"}, defaults={"page"=1})
     * @ParamConverter("criteria", options={"form"=ProductCriteriaType::class, "required"=false})
     */
    public function index(ProductRepositoryInterface $repository, ProductCriteria $criteria, int $page = 1): Page
    {
        return $repository->paginate($criteria, $page, self::PRODUCTS_PER_PAGE);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     * @ParamConverter("dto", options={"form"=ProductType::class, "validation_groups"={"Default", "Create"}})
     *
     * @IsGranted(ProductVoter::PERMISSION_CREATE)
     */
    public function create(ProductDTO $dto, CreateProduct $createProduct, UserInterface $owner): ProductView
    {
        /** @var User $owner */
        $product = $createProduct->execute($dto, $owner);

        $this->em->flush();
        $this->em->refresh($product);

        return new ProductView($product);
    }

    /**
     * @Route("/{id}", name="update", methods={"POST"}, requirements={"id"="^[1-9]\d*$"})
     * @ParamConverter("dto", options={"form"=ProductType::class})
     *
     * @IsGranted(ProductVoter::PERMISSION_UPDATE, subject="product")
     */
    public function update(Product $product, ProductDTO $dto, UpdateProduct $updateProduct): ProductView
    {
        $updateProduct->execute($product, $dto);

        $this->em->flush();
        $this->em->refresh($product);

        return new ProductView($product);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id"="^[1-9]\d*$"})
     * @IsGranted(ProductVoter::PERMISSION_DELETE, subject="product")
     */
    public function delete(Product $product, DeleteProduct $deleteProduct): void
    {
        $deleteProduct->execute($product);
    }
}
