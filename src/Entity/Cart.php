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

    public function addItem(CartItem $item): void
    {
        if (!$this->items->contains($item)) {
            $item->setCart($this);
            $this->items->add($item);
        }
    }

    public function addProduct(Product $product, int $quantity): void
    {
        $criteria = Criteria::create()->andWhere(
            Criteria::expr()->eq('product', $product)
        );

        /**
         * @var CartItem $item
         * @psalm-suppress UndefinedInterfaceMethod
         */
        $item = $this->items->matching($criteria)->current();

        if ($item) {
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            $item = new CartItem();
            $item
                ->setCart($this)
                ->setProduct($product)
                ->setQuantity($quantity);

            $this->items->add($item);
        }
    }

    public function removeProduct(Product $product, int $quantity): void
    {
        $criteria = Criteria::create()->andWhere(
            Criteria::expr()->eq('product', $product->getId())
        );

        /**
         * @var CartItem $item
         *
         * @psalm-suppress UndefinedInterfaceMethod
         */
        $item = $this->items->matching($criteria)->first();

        if ($item === null) {
            return;
        }

        $item->setQuantity($item->getQuantity() - $quantity);

        if ($item->getQuantity() <= 0) {
            $this->items->removeElement($item);
        }
    }
}
