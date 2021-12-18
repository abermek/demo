<?php

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Money\Currency;

class CurrencyType extends Type
{
    private const NAME = 'currency';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL([
            'length' => 3,
            'fixed' => true
       ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof Currency) {
            return $value;
        }
        try {
            $currency = new Currency($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
        return $currency;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof Currency) {
            return $value->getCode();
        }
        try {
            $currency = new Currency($value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }

        return $currency->getCode();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
