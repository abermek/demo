<?php

namespace App\Entity;

use App\Entity\Security\User;
use Money\Money;

class Product
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $slug = null;
    private ?Money $price = null;
    private User $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): Product
    {
        $this->owner = $owner;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): Product
    {
        $this->slug = $slug;
        return $this;
    }

    public function getPrice(): ?Money
    {
        return $this->price;
    }

    public function setPrice(?Money $price): Product
    {
        $this->price = $price;
        return $this;
    }
}
