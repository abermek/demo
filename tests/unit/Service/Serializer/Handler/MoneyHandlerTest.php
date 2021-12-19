<?php

namespace Tests\Unit\Service\Serializer\Handler;

use App\Serializer\SubscribingHandler\MoneyHandler;
use App\Service\Money\Format;
use Codeception\Test\Unit;
use JMS\Serializer\JsonSerializationVisitor;
use Mockery;
use Mockery\MockInterface;
use Money\Money;

class MoneyHandlerTest extends Unit
{
    private Format|MockInterface $formatter;

    public function testSerialize()
    {
        $money = Money::USD(10);
        $formatted = '$10';

        $this->formatter
            ->shouldReceive('execute')
            ->with($money)
            ->andReturn($formatted);

        $result = $this->getSystemUnderTest()->serialize(new JsonSerializationVisitor(), $money);

        self::assertEquals($formatted, $result);
    }

    public function getSystemUnderTest(): MoneyHandler
    {
        return new MoneyHandler($this->formatter);
    }

    protected function _before()
    {
        $this->formatter = Mockery::mock(Format::class);
    }
}
