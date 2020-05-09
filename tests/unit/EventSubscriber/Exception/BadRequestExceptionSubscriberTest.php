<?php

namespace App\Tests\EventSubscriber\Exception;

use App\EventSubscriber\Exception\BadRequestExceptionSubscriber;
use App\Exception\BadRequest\FormValidationFailedException;
use App\DTO\BadRequest\ReasonList;
use Codeception\Test\Unit;
use Exception;
use JMS\Serializer\SerializerInterface;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BadRequestExceptionSubscriberTest extends Unit
{
    /** @var SerializerInterface | MockInterface */
    private $serializer;

    protected function _before()
    {
        $this->serializer = Mockery::mock(SerializerInterface::class);
    }

    public function getSystemUnderTest(): BadRequestExceptionSubscriber
    {
        return new BadRequestExceptionSubscriber($this->serializer);
    }

    public function testItListensToTheKernelException()
    {
        self::assertArrayHasKey(
            KernelEvents::EXCEPTION,
            BadRequestExceptionSubscriber::getSubscribedEvents()
        );
    }

    public function testItRespondsOnlyOnBadRequestExceptionInterface()
    {
        /** @var ExceptionEvent|MockInterface $event */
        $event      = Mockery::mock(ExceptionEvent::class);
        $exception  = new Exception('Some Random String');

        $event
            ->shouldReceive('getThrowable')
            ->andReturn($exception);

        $event->shouldNotReceive('setResponse');
        $this->serializer->shouldNotReceive('serialize');

        $this->getSystemUnderTest()->onKernelException($event);
    }

    public function testItHandlesFormValidationException()
    {
        /** @var ReasonList|MockInterface $reasons */
        $reasons = Mockery::mock(ReasonList::class);
        /** @var FormValidationFailedException|MockInterface $exception */
        $exception = Mockery::mock(FormValidationFailedException::class);
        /** @var ExceptionEvent|MockInterface $event */
        $event = Mockery::mock(ExceptionEvent::class);

        $event
            ->shouldReceive('getThrowable')
            ->andReturn($exception);

        $exception
            ->shouldReceive('getReasons')
            ->andReturn($reasons);

        $this->serializer
            ->shouldReceive('serialize')
            ->with($reasons, 'json')
            ->andReturn("");

        $matcher = function ($response) {
            return $response instanceof Response
                && $response->getStatusCode() === Response::HTTP_BAD_REQUEST;
        };

        $event
            ->shouldReceive('setResponse')
            ->with(Mockery::on($matcher));

        $this->getSystemUnderTest()->onKernelException($event);
    }
}
