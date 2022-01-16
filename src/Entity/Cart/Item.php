<?php

namespace App\Entity\Cart;

use App\Entity\Cart;
use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity, ORM\Table(name: 'cart_items')]
#[Serializer\ExclusionPolicy(policy: Serializer\ExclusionPolicy::ALL)]
class Item
{
    use GeneratedValueTrait;

    #[ORM\ManyToOne(targetEntity: Product::class), ORM\JoinColumn(onDelete: 'CASCADE')]
    #[Assert\NotNull]
    #[Serializer\Expose]
    public ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Cart::class), ORM\JoinColumn(onDelete: 'CASCADE')]
    public ?Cart $cart = null;

    #[ORM\Column(nullable: false)]
    #[Assert\NotNull, Assert\GreaterThan(value: 0)]
    #[Serializer\Expose]
    public ?int $quantity = null;
}
