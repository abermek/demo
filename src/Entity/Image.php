<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 */
class Image
{
    use Timestampable;
    use GeneratedValueTrait;

    public const FILE_FIELD_NAME = 'file';
    public ?int $size = null;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $url = null;
    /**
     * @Vich\UploadableField(
     *     mapping="images",
     *     fileNameProperty="name",
     *     size="size",
     *     mimeType="type"
     * )
     */
    public ?File $file;
}
