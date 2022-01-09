<?php

namespace App\Entity;

use App\Entity\Cart\Item;
use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use IteratorAggregate;
use Traversable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="carts")
 */
class Cart implements Countable, IteratorAggregate
{
    use GeneratedValueTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(name="user_id", onDelete="CASCADE")
     */
    public ?User $owner = null;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cart\Item", cascade={"persist","remove"}, mappedBy="cart")
     */
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
