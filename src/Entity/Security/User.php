<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Cart;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
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

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function setSalt(string $salt): User
    {
        $this->salt = $salt;

        return $this;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
