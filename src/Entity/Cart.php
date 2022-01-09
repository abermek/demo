<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart implements Countable
{
    use GeneratedValueTrait;

    public ?User $owner = null;
    public Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function findProduct(Product $product): ?CartItem
    {
        $item = $this->items->filter(fn(CartItem $item) => $item->product === $product)->first();

        return $item ?: null;
    }
}
