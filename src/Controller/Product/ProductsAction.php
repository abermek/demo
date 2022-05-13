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
    path: '/products',
    name: 'products',
    methods: ['GET']
)]
class ProductsAction
{
    public function __invoke(
        ProductPagination $pagination,
        #[Input(FilterType::class)] Filter $filter
    ): PaginationResponse | View {
        try {
            return new PaginationResponse(
                $pagination->execute($filter, $filter->page, $filter->limit)
            );
        } catch (OutOfRangeCurrentPageException) {
            return View::create(new InvalidPageResponse($filter->page), Response::HTTP_BAD_REQUEST);
        }
    }
}
