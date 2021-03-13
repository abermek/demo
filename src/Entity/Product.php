<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\InputInterface;
use App\Entity\Security\User;
use App\Money\MoneyInterface;

class Product implements InputInterface
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
