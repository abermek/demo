<?php

namespace App\Service\Pricing\Strategy;

use App\Entity\Cart;
use App\Exception\Pricing\PricingStrategy\EmptyPurchasesException;
use App\Contract\Pricing\PricingStrategy;
use App\DTO\Receipt;
use App\DTO\Receipt\Item;

class DefaultStrategy implements PricingStrategy
{
    public function execute(Cart $cart): Receipt
    {
        $grandTotal = null;
        $items = [];

        if (count($cart) === 0) {
            throw new EmptyPurchasesException();
        }

        /** @var Cart\Item $item */
        foreach ($cart as $item) {
            $subtotal = $item->product->price->multiply($item->quantity);

            is_null($grandTotal)
                ? $grandTotal = $subtotal
                : $grandTotal = $grandTotal->add($subtotal);

            $items[] = new Item(
                $item->product->name,
                $item->quantity,
                $item->product->price,
                $subtotal
            );
        }

        return new Receipt($grandTotal, ...$items);
    }
}
