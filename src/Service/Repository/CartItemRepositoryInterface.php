<?php

namespace App\Service\Repository;

use App\DTO\CartItem\CartItemCriteria;
use App\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function first(CartItemCriteria $criteria): ?CartItem;
}