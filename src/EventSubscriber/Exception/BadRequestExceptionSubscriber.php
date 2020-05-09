<?php declare(strict_types=1);

namespace App\EventSubscriber\Exception;

use App\Exception\BadRequest\BadRequestExceptionInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class BadRequestExceptionSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof BadRequestExceptionInterface) {
            return;
        }

        $response = new Response(
            $this->serializer->serialize($exception->getReasons(), 'json'),
            Response::HTTP_BAD_REQUEST,
            [
                'Content-Type' => 'text/javascript'
            ]
        );

        $event->setResponse($response);
    }
}
