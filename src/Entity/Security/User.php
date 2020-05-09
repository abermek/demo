<?php declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Cart;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table("users")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     *
     * @Serializer\Expose()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @var Cart
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Cart", mappedBy="owner", cascade={"remove"})
     */
    private $cart;

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
}
