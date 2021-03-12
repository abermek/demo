<?php

declare(strict_types=1);

namespace App\Model\Money;

use App\Model\Money;

final class USD extends Money
{
    public function __construct(int $amount)
    {
        parent::__construct($amount, 'USD');
    }
}
