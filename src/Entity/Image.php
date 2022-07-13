<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity, ORM\Table(name: 'images')]
#[Serializer\ExclusionPolicy(policy: Serializer\ExclusionPolicy::ALL)]
#[Vich\Uploadable]
class Image
{
    use GeneratedValueTrait;

    public const FILE_FIELD_NAME = 'file';

    #[ORM\Column]
    public ?int $size = null;

    #[ORM\Column(length: 255)]
    #[Serializer\Expose]
    public ?string $name = null;

    #[ORM\Column(length: 255)]
    public ?string $type = null;

    #[Assert\Image]
    #[Vich\UploadableField(mapping: "images", fileNameProperty: "name", size: "size", mimeType: "type")]
    public ?File $file;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    public ?DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    public ?DateTime $updatedAt = null;

    #[Serializer\Expose]
    public ?string $url = null;
}
