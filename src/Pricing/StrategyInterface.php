<?php

namespace App\Pricing;

interface StrategyInterface
{
    public function execute(PurchaseInterface ...$purchases): ReceiptInterface;
}