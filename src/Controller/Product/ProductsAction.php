<?php

namespace App\Controller\Product;

use App\Attribute\Input;
use App\Doctrine\Pagination\ProductPagination;
use App\DTO\Product\Filter;
use App\DTO\Response\BadRequest\InvalidPageResponse;
use App\DTO\Response\PaginationResponse;
use App\Form\Type\Product\FilterType;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\RequestBody(request=FilterType::class, required=true)
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
class ProductsAction
{
    private const PRODUCTS_PER_PAGE = 20;

    public function __invoke(
        ProductPagination $pagination,
        #[Input(FilterType::class)] Filter $search,
        int $page = 1
    ): PaginationResponse | View {
        try {
            return new PaginationResponse(
                $pagination->execute($search, $page, self::PRODUCTS_PER_PAGE)
            );
        } catch (OutOfRangeCurrentPageException) {
            return View::create(new InvalidPageResponse($page), Response::HTTP_BAD_REQUEST);
        }
    }
}
