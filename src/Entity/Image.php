<?php

namespace App\Entity;

use DateTime;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 */
class Image
{
    use Timestampable;

    public const FILE_FIELD_NAME = 'file';

    private ?int $id = null;
    private ?int $size = null;
    private ?string $name = null;
    private ?string $type = null;
    private ?string $url = null;

    /**
     * @Vich\UploadableField(
     *     mapping="images",
     *     fileNameProperty="name",
     *     size="size",
     *     mimeType="type"
     * )
     */
    private ?File $file;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Image
    {
        $this->name = $name;
        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): Image
    {
        $this->size = $size;
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file = null): Image
    {
        $this->file = $file;

        if ($file !== null) {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Image
    {
        $this->type = $type;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): Image
    {
        $this->url = $url;
        return $this;
    }
}
