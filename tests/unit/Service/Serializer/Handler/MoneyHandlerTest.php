<?php

namespace App\Tests\Service\Serializer\Handler;

use App\Service\Money\MoneyFormatter;
use App\Service\Serializer\Handler\MoneyHandler;
use Codeception\Test\Unit;
use App\Money\MoneyInterface;
use JMS\Serializer\Context;
use JMS\Serializer\JsonSerializationVisitor;
use Mockery;
use Mockery\MockInterface;

class MoneyHandlerTest extends Unit
{
    /** @var MoneyFormatter | MockInterface */
    private $formatter;

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
        /** @var Context|MockInterface $context */
        $context = Mockery::mock(Context::class);
        /** @var MoneyInterface|MockInterface $money */
        $money   = Mockery::mock(MoneyInterface::class);

        $formatted = '$10';

        $this->formatter
            ->shouldReceive('format')
            ->with($money)
            ->andReturn($formatted);

        $result = $this->getSystemUnderTest()->serialize(new JsonSerializationVisitor(), $money, [], $context);

        self::assertEquals($formatted, $result);
    }
}