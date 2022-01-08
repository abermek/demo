<?php

namespace App\Entity;

use App\Entity\Security\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class Cart
{
    private ?int $id = null;

    private User $owner;
    private Collection $items;

    public function __construct(User $owner)
    {
        $this->items = new ArrayCollection();
        $this->owner = $owner;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEmpty(): bool
    {
        return !$this->items->count();
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getCustomer(): User
    {
        return $this->owner;
    }
}
