<?php

namespace App\Entity\Identity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

trait GeneratedValueTrait
{
    #[ORM\Column, ORM\Id, ORM\GeneratedValue]
    #[Serializer\Expose]
    protected ?int $id;

    # https://www.doctrine-project.org/2022/01/11/orm-2.11.html
    # Despite the article readonly id breaks when you delete an Entity, waiting for fix
    public function getId(): ?int
    {
        return $this->id;
    }
}
