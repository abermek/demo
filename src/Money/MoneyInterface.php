<?php

namespace App\Money;

interface MoneyInterface
{
    public function getAmount(): int;

    public function getCurrency(): string;
}