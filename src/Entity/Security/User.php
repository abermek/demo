<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Cart;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $salt = null;
    private ?Cart $cart = null;
    private array $roles;

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

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): User
    {
        $this->salt = $salt;

        return $this;
    }

    /** @psalm-suppress InvalidNullableReturnType */
    public function getUsername(): ?string
    {
        /** @psalm-suppress NullableReturnStatement */
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): User
    {
        $this->cart = $cart;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
