<?php

namespace App\Entity;

use App\Money\MoneyInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Money implements MoneyInterface
{
    /**
     * @Assert\GreaterThan(0)
     */
    protected int $amount;

    /**
     * @Assert\Length(min="3", max="3")
     */
    protected string $currency;

    public function __construct(int $amount, string $currency)
    {
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
