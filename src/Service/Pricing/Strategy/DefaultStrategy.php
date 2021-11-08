<?php

namespace App\Service\Pricing\Strategy;

use App\Exception\Pricing\PricingStrategy\EmptyPurchasesException;
use App\Pricing\Receipt;
use App\Pricing\ReceiptItem;
use App\Money\MathInterface;
use App\Pricing\PricingStrategy;
use App\Pricing\PurchaseInterface;

class DefaultStrategy implements PricingStrategy
{
    public function __construct(private MathInterface $math)
    {
    }

    public function execute(PurchaseInterface ...$purchases): Receipt
    {
        $items = [];
        $grandTotal = null;

        if (empty($purchases)) {
            throw new EmptyPurchasesException();
        }

        foreach ($purchases as $purchase) {
            $subtotal = $this->math->multiply($purchase->getProductPrice(), $purchase->getProductQuantity());

            is_null($grandTotal)
                ? $grandTotal = $subtotal
                : $grandTotal = $this->math->add($grandTotal, $subtotal);

            $items[] = new ReceiptItem(
                $purchase->getProductName(),
                $purchase->getProductQuantity(),
                $purchase->getProductPrice(),
                $subtotal
            );
        }

        return new Receipt($grandTotal, ...$items);
    }
}
