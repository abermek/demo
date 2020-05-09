<?php

namespace App\Entity;

use App\Money\MoneyInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable()
 */
class Money implements MoneyInterface
{
    /**
     * @ORM\Column(type="bigint")
     *
     * @Assert\GreaterThan(0)
     */
    protected int $amount;

    /**
     * @ORM\Column(type="string", length=3)
     *
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