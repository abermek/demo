<?php

namespace App\Entity\Identity;

use Doctrine\ORM\Mapping as ORM;

trait GeneratedValueTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    protected ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
