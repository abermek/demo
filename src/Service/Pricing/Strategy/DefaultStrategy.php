<?php

namespace App\Service\Pricing\Strategy;

use App\Exception\Pricing\PricingStrategy\EmptyPurchasesException;
use App\Pricing\PricingStrategy;
use App\Pricing\Purchase;
use App\Pricing\Receipt;
use App\Pricing\ReceiptItem;

class DefaultStrategy implements PricingStrategy
{
    public function execute(Purchase ...$purchases): Receipt
    {
        $items = [];
        $grandTotal = null;

        if (empty($purchases)) {
            throw new EmptyPurchasesException();
        }

        foreach ($purchases as $purchase) {
            $product = $purchase->getProduct();
            $subtotal = $product->price->multiply($purchase->getQuantity());

            is_null($grandTotal)
                ? $grandTotal = $subtotal
                : $grandTotal = $grandTotal->add($subtotal);

            $items[] = new ReceiptItem(
                $product->name,
                $purchase->getQuantity(),
                $product->price,
                $subtotal
            );
        }

        return new Receipt($grandTotal, ...$items);
    }
}
