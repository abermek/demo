<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Security\User;
use App\Money\MoneyInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("products")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private User $owner;

    /**
     * @ORM\Embedded(class="App\Entity\Money")
     */
    private ?Money $price = null;

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

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getPrice(): ?MoneyInterface
    {
        return $this->price;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(?MoneyInterface $price): Product
    {
        $this->price = is_null($price)
            ? null
            : new Money($price->getAmount(), $price->getCurrency());

        return $this;
    }
}
