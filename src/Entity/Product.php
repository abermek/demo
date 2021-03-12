<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Security\User;
use App\Money\MoneyInterface;

class Product
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $slug = null;
    private ?Money $price = null;
    private User $owner;

    public function __construct(User $owner)
    {
        $this->owner = $owner;
    }

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

    public function getPrice(): ?MoneyInterface
    {
        return $this->price;
    }

    public function setPrice(?MoneyInterface $price): Product
    {
        $this->price = is_null($price)
            ? null
            : new Money($price->getAmount(), $price->getCurrency());

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
}
