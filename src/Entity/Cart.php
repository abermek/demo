<?php

namespace App\Entity;

use App\Entity\Cart\Item;
use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use IteratorAggregate;
use Traversable;

class Cart implements Countable, IteratorAggregate
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

    public function getIterator(): Traversable
    {
        return $this->items->getIterator();
    }

    public function findProduct(Product $product): ?Item
    {
        $item = $this->items->filter(fn(Item $item) => $item->product === $product)->first();

        return $item ?: null;
    }
}
