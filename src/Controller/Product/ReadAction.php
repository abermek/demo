<?php

namespace App\Controller\Product;

use App\Attribute\Input;
use App\DTO\Product\ProductFilters;
use App\DTO\Response\BadRequest\InvalidPageResponse;
use App\DTO\Response\PaginationResponse;
use App\Form\Type\Product\ProductFiltersType;
use App\Repository\Doctrine\ProductRepository;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\RequestBody(request=ProductFiltersType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Returns list of the Products",
 *     @SWG\Model(type=PaginationResponse::class)
 * )
 * @OA\Tag(name="Product")
 * @SWG\Security(name="Bearer")
 */
#[Route(
    path: '/products/{page}',
    name: 'products',
    requirements: ['page' => '^[1-9]\d*$'],
    defaults: ['page' => 1],
    methods: ['GET']
)]
class ReadAction
{
    private const PRODUCTS_PER_PAGE = 20;

    public function __invoke(
        ProductRepository $repository,
        #[Input(ProductFiltersType::class)] ProductFilters $criteria,
        int $page = 1
    ): PaginationResponse | View {
        try {
            return new PaginationResponse(
                $repository->paginate($criteria, $page, self::PRODUCTS_PER_PAGE)
            );
        } catch (OutOfRangeCurrentPageException) {
            return View::create(new InvalidPageResponse($page), Response::HTTP_BAD_REQUEST);
        }
    }
}
