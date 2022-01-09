<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Cart;
use App\Entity\Identity\GeneratedValueTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use GeneratedValueTrait;

    /**
     * @ORM\Column(length=255,nullable=false,unique=true)
     */
    public ?string $username = null;
    /**
     * @ORM\Column(length=255,nullable=false)
     */
    public ?string $password = null;
    /**
     * @ORM\Column(length=255,nullable=false)
     */
    public ?string $salt = null;
    /**
     * @ORM\Column(type="json")
     */
    public array $roles;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cart", cascade={"remove"}, mappedBy="owner")
     */
    public ?Cart $cart = null;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /** @psalm-suppress InvalidNullableReturnType */
    public function getUsername(): ?string
    {
        /** @psalm-suppress NullableReturnStatement */
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }
}
