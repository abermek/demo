<?php

namespace App\Serializer\SubscribingHandler;

use App\Service\Money\Formatter;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Money\Money;

class MoneyHandler implements SubscribingHandlerInterface
{
    public function __construct(private Formatter $formatter)
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

    public function serialize(JsonSerializationVisitor $visitor, Money $money): array
    {
        return [
            'amount' => $this->formatter->decimal($money),
            'currency' => $money->getCurrency()->getCode()
        ];
    }
}
