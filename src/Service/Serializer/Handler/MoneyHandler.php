<?php

namespace App\Service\Serializer\Handler;

use App\Money\Money;
use App\Entity\Money as EmbeddedMoney;
use App\Money\MoneyInterface;
use App\Service\Money\MoneyFormatter;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

class MoneyHandler implements SubscribingHandlerInterface
{
    public function __construct(private MoneyFormatter $formatter)
    {}

    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => Money::class,
                'method'    => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => EmbeddedMoney::class,
                'method'    => 'serialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, MoneyInterface $money): string
    {
        return $this->formatter->format($money);
    }
}
