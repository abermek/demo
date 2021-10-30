<?php

namespace App\Serializer\EventSubscriber;

use App\Entity\Image;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private UploaderHelper $uploaderHelper)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            [
                'event' => Events::PRE_SERIALIZE,
                'format' => 'json',
                'class' => Image::class,
                'method' => 'onPreSerialize',
            ]
        ];
    }

    public function onPreSerialize(PreSerializeEvent $event): void
    {
        /** @var Image $image */
        $image = $event->getObject();
        $image->setUrl($this->uploaderHelper->asset($image, Image::FILE_FIELD_NAME));
    }
}
