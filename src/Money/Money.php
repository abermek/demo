<?php declare(strict_types=1);

namespace App\Money;

use Exception;

class Money implements MoneyInterface
{
    private int $amount;
    private string $currency;

    public function __construct(int $amount, string $currency)
    {
        if ($amount <= 0) {
            throw new Exception('Amount should be greater then 0');
        }

        $this->amount = $amount;
        $this->currency = $currency;
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
