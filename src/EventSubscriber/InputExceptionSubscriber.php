<?php

namespace App\EventSubscriber;

use App\DTO\Response\BadRequest\InvalidFormResponse;
use App\Exception\Input\InvalidInputException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InputExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onInvalidInput'
        ];
    }

    public function onInvalidInput(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof InvalidInputException) {
            return;
        }

        $data = $this->serializer->toArray(new InvalidFormResponse($exception->form));
        $response = new JsonResponse($data, Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}
