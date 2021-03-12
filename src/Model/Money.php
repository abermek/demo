<?php

declare(strict_types=1);

namespace App\Model;

use App\Money\MoneyInterface;
use Exception;

class Money implements MoneyInterface
{
    public function __construct(private int $amount, private string $currency)
    {
        if ($amount <= 0) {
            throw new Exception('Amount should be greater then 0');
        }
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
