<?php

namespace App\Serializer\SubscribingHandler;

use App\Service\Money\Format;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Money\Money;

class MoneyHandler implements SubscribingHandlerInterface
{
    public function __construct(private Format $format)
    {
    }

    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Money::class,
                'method' => 'serialize',
            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Money $money): string
    {
        return $this->format->execute($money);
    }
}
