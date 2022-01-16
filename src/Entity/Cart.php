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
use JMS\Serializer\Annotation as Serializer;
use Traversable;

#[ORM\Entity, ORM\Table(name: 'carts')]
#[Serializer\ExclusionPolicy(policy: Serializer\ExclusionPolicy::ALL)]
class Cart implements Countable, IteratorAggregate
{
    use GeneratedValueTrait;

    #[ORM\OneToOne(targetEntity: User::class), ORM\JoinColumn(name: 'user_id', onDelete: 'CASCADE')]
    public ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: Item::class, cascade: ['persist', 'remove'])]
    #[Serializer\Expose]
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
