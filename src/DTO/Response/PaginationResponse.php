<?php

namespace App\DTO\Response;

use Pagerfanta\Pagerfanta;

class PaginationResponse
{
    public array $items;
    public int $page;
    public int $total;

    public function __construct(Pagerfanta $paginator)
    {
        $this->items = iterator_to_array($paginator->getCurrentPageResults());
        $this->page = $paginator->getCurrentPage();
        $this->total = $paginator->getNbPages();
    }
}
