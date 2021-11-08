<?php

namespace App\Service\Pricing\Strategy;

use App\Exception\Pricing\PricingStrategy\EmptyPurchasesException;
use App\Pricing\Receipt;
use App\Pricing\ReceiptItem;
use App\Money\MathInterface;
use App\Pricing\PricingStrategy;
use App\Pricing\Purchase;

class DefaultStrategy implements PricingStrategy
{
    public function __construct(private MathInterface $math)
    {
    }

    public function execute(Purchase ...$purchases): Receipt
    {
        $items = [];
        $grandTotal = null;

        if (empty($purchases)) {
            throw new EmptyPurchasesException();
        }

        foreach ($purchases as $purchase) {
            $subtotal = $this->math->multiply($purchase->getProduct()->getPrice(), $purchase->getQuantity());

            is_null($grandTotal)
                ? $grandTotal = $subtotal
                : $grandTotal = $this->math->add($grandTotal, $subtotal);

            $items[] = new ReceiptItem(
                $purchase->getProduct()->getName(),
                $purchase->getQuantity(),
                $purchase->getProduct()->getPrice(),
                $subtotal
            );
        }

        return new Receipt($grandTotal, ...$items);
    }
}
