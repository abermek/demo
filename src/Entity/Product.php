<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Security\User;
use App\Money\MoneyInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private User $owner;

    /**
     * @ORM\Embedded(class="App\Entity\Money")
     */
    private Money $price;

    public function __construct(string $name, MoneyInterface $price, User $owner)
    {
        $this->name = $name;
        $this->price = new Money($price->getAmount(), $price->getCurrency());
        $this->owner = $owner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getPrice(): MoneyInterface
    {
        return $this->price;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function updatePrice(MoneyInterface $price): void
    {
        $this->price = new Money(
            $price->getAmount(),
            $price->getCurrency()
        );
    }
}
