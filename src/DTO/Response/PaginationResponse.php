<?php

namespace App\DTO\Response;

use Pagerfanta\Pagerfanta;

class PaginationResponse
{
    public iterable $items;
    public int $page;
    public int $total;

    public function __construct(Pagerfanta $paginator)
    {
        $this->items = $paginator->getCurrentPageResults();
        $this->page = $paginator->getCurrentPage();
        $this->total = $paginator->getNbPages();
    }
}
