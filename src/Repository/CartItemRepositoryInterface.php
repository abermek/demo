<?php

namespace App\Repository;

use App\DTO\CartItem\CartItemCriteria;
use App\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function findOne(CartItemCriteria $criteria): ?CartItem;
}
