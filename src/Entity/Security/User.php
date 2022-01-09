<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Cart;
use App\Entity\Identity\GeneratedValueTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use GeneratedValueTrait;

    public ?string $username = null;
    public ?string $password = null;
    public ?string $salt = null;
    public ?Cart $cart = null;
    public array $roles;

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
