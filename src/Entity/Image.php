<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @ORM\Table(name="images")
 *
 * @Vich\Uploadable()
 */
class Image
{
    use GeneratedValueTrait;

    public const FILE_FIELD_NAME = 'file';
    /**
     * @ORM\Column(type="integer")
     */
    public ?int $size = null;
    /**
     * @ORM\Column(length=255)
     */
    public ?string $name = null;
    /**
     * @ORM\Column(length=255)
     */
    public ?string $type = null;
    /**
     * @Vich\UploadableField(
     *     mapping="images",
     *     fileNameProperty="name",
     *     size="size",
     *     mimeType="type"
     * )
     */
    public ?File $file;
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    public ?DateTime $createdAt=null;
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    public ?DateTime $updatedAt=null;
    public ?string $url = null;
}
