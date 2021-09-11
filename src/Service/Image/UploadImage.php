<?php

namespace App\Service\Image;

use App\Entity\Image;
use Liip\ImagineBundle\Service\FilterService;
use Vich\UploaderBundle\Handler\UploadHandler;

class UploadImage
{
    public function __construct(
        private UploadHandler $uploadHandler,
        private FilterService $filter,
        private string $filterSet
    ) {
    }

    public function execute(Image $image): void
    {
        $this->uploadHandler->upload($image, Image::FILE_FIELD_NAME);
        $this->filter->getUrlOfFilteredImage($image->getName(), $this->filterSet);
    }
}
