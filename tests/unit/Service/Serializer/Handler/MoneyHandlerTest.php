<?php

namespace Tests\Unit\Service\Serializer\Handler;

use App\Service\Money\MoneyFormatter;
use App\Serializer\SubscribingHandler\MoneyHandler;
use Codeception\Test\Unit;
use App\Money\MoneyInterface;
use JMS\Serializer\Context;
use JMS\Serializer\JsonSerializationVisitor;
use Mockery;
use Mockery\MockInterface;

class MoneyHandlerTest extends Unit
{
    private MoneyFormatter | MockInterface $formatter;

    protected function _before()
    {
        $this->formatter = Mockery::mock(MoneyFormatter::class);
    }

    public function getSystemUnderTest(): MoneyHandler
    {
        return new MoneyHandler($this->formatter);
    }

    public function testSerialize()
    {
        $context = Mockery::mock(Context::class);
        $money   = Mockery::mock(MoneyInterface::class);

        $formatted = '$10';

        $this->formatter
            ->shouldReceive('format')
            ->with($money)
            ->andReturn($formatted);

        $result = $this->getSystemUnderTest()->serialize(new JsonSerializationVisitor(), $money);

        self::assertEquals($formatted, $result);
    }
}
