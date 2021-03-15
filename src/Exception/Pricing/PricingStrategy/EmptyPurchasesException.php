<?php

namespace App\Exception\Pricing\PricingStrategy;

use Exception;

class EmptyPurchasesException extends Exception
{
    public function __construct()
    {
        parent::__construct('Pricing Strategy requires at least one Purchase to calculate a price');
    }
}
