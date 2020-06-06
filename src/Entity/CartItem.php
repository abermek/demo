<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("cart_items")
 */
class CartItem
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private ?Product $product = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="items")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private ?Cart $cart = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): CartItem
    {
        $this->product = $product;
        return $this;
    }

    public function setCart(?Cart $cart): CartItem
    {
        $this->cart = $cart;
        return $this;
    }

    public function setQuantity(?int $quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function increaseQuantity(int $amount): CartItem
    {
        $this->quantity += $amount;

        return $this;
    }
}