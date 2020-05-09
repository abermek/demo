<?php declare(strict_types=1);

namespace App\Money;

final class USD extends Money
{
    public function __construct(int $amount)
    {
        parent::__construct($amount, 'USD');
    }
}
