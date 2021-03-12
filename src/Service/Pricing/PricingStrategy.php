<?php

namespace App\Service\Pricing;

use App\Model\Pricing\Receipt;
use App\Model\Pricing\Receipt\Item;
use App\Money\MathInterface;
use App\Pricing\PurchaseInterface;
use App\Pricing\ReceiptInterface;
use App\Pricing\StrategyInterface;

class PricingStrategy implements StrategyInterface
{
    public function __construct(private MathInterface $math)
    {}

    public function execute(PurchaseInterface ...$purchases): ReceiptInterface
    {
        $items = [];
        $grandTotal = null;

        foreach ($purchases as $purchase) {
            $subtotal = $this->math->multiply($purchase->getProductPrice(), $purchase->getProductQuantity());

            is_null($grandTotal)
                ? $grandTotal = $subtotal
                : $grandTotal = $this->math->add($grandTotal, $subtotal);

            $items[] = new Item(
                $purchase->getProductName(),
                $purchase->getProductQuantity(),
                $purchase->getProductPrice(),
                $subtotal
            );
        }

        return new Receipt($grandTotal, ...$items);
    }
}