<?php

namespace App\DTO\Doctrine;

use App\DTO\Product\ProductFilters;
use Doctrine\Common\Collections\Criteria;

class ProductCriteria extends Criteria
{
    public static function fromFilters(ProductFilters $filters): self
    {
        $criteria = new self();

        if (!empty($filters->name)) {
            $criteria->andWhere(self::expr()->eq('name', $filters->name));
        }

        if (!empty($filters->slug)) {
            $criteria->andWhere(self::expr()->eq('slug', $filters->slug));
        }

        return $criteria;
    }
}
