<?php

namespace App\Doctrine\Criteria;

use App\Doctrine\Criteria;
use App\DTO\Product\Search;

class ProductCriteria extends Criteria
{
    public function __construct(Search $search)
    {
        if ($search->name) {
            $this->expressions[] = Criteria::expr()->eq('p.name', $search->name);
        }

        if ($search->slug) {
            $this->expressions[] = Criteria::expr()->eq('p.slug', $search->slug);
        }

        parent::__construct();
    }
}
