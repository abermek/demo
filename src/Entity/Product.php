<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator;

#[ORM\Entity, ORM\Table(name: 'products')]
#[Serializer\ExclusionPolicy(policy: Serializer\ExclusionPolicy::ALL)]
class Product
{
    use GeneratedValueTrait;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(groups: ['Create']), Assert\Regex(pattern: "/^[\w\s\+]+/"), Assert\Length(min: 3, max: 200)]
    #[Serializer\Expose]
    public ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['name'], updatable: true, style: 'camel', unique: true, separator: '-')]
    public ?string $slug = null;

    /**
     * @Validator\Money\GreaterThan(value=0)
     * @Validator\Currency\Choice(choices={"USD"})
     */
    #[ORM\Embedded(class: Money::class)]
    #[Assert\NotNull(groups: ['Create'])]
    #[Serializer\Expose]
    public ?Money $price = null;

    #[ORM\ManyToOne(targetEntity: User::class), ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public ?User $owner = null;
}
