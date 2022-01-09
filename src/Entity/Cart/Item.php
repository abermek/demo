<?php

namespace App\Entity\Cart;

use App\Entity\Cart;
use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cart_items")
 */
class Item
{
    use GeneratedValueTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    public ?Product $product = null;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    public ?Cart $cart = null;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    public ?int $quantity = null;
}
