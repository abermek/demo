<?php

namespace App\Service\Image;

use App\Entity\Image;
use App\Message\FilterImageMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Vich\UploaderBundle\Handler\UploadHandler;

class UploadImage
{
    public function __construct(
        private UploadHandler $uploadHandler,
        private MessageBusInterface $bus,
        private string $imageFilterWebp
    ) {
    }

    public function execute(Image $image): void
    {
        $this->uploadHandler->upload($image, Image::FILE_FIELD_NAME);
        $this->bus->dispatch(new FilterImageMessage($image->getName(), $this->imageFilterWebp));
    }
}
