<?php

namespace App\MessageHandler;

use App\Message\FilterImageMessage;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FilterImageHandler implements MessageHandlerInterface
{
    public function __construct(private FilterService $filterService)
    {
    }

    public function __invoke(FilterImageMessage $message)
    {
        $this->filterService->getUrlOfFilteredImage($message->getImage(), $message->getFilter());
    }
}
