<?php

namespace App\Cart;

use App\Entity\CartItem;

interface CartInterface
{
    public function addItem(CartItem $item): void;

    public function getItems(): iterable;

    public function isEmpty(): bool;
}