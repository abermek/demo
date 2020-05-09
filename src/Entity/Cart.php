<?php

namespace App\Entity;

use App\Cart\CartInterface;
use App\Entity\Security\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("carts")
 */
class Cart implements CartInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Security\User", inversedBy="cart")
     * @ORM\JoinColumn(name="user_id", onDelete="CASCADE")
     */
    private $owner;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CartItem", mappedBy="cart", cascade={"all"})
     */
    private Collection $items;

    public function __construct(User $owner)
    {
        $this->items = new ArrayCollection();
        $this->owner = $owner;
    }

    /** @return CartItem [] */
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
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('product', $item->getProduct()))
            ->setMaxResults(1);

        /** @var CartItem $tmp */
        $tmp = $this->items->matching($criteria)->first();

        if ($tmp instanceof CartItem) {
            $tmp->increaseQuantity($item->getQuantity());
        } else {
            $item->setCart($this);
            $this->items->add($item);
        }
    }
}