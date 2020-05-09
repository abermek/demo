<?php

namespace App\Service\Repository;

use App\Entity\Cart;

interface CartRepositoryInterface
{
    public function create(Cart $cart): void;
}