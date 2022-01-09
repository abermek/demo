<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Money\Money;

/**
 * @ORM\Entity()
 * @ORM\Table(name="products")
 */
class Product
{
    use GeneratedValueTrait;

    /**
     * @ORM\Column(length=200)
     */
    public ?string $name = null;
    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(unique=true,style="camel",updatable=true,separator="-",fields={"name"})
     */
    public ?string $slug = null;
    /**
     * @ORM\Embedded(class="Money\Money")
     */
    public ?Money $price = null;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(onDelete="CASCADE",nullable=false)
     */
    public ?User $owner = null;
}
