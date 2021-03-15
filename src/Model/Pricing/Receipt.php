<?php

namespace App\Model\Pricing;

use App\Exception\Pricing\Receipt\EmptyItemsException;
use App\Money\MoneyInterface;
use App\Pricing\Receipt\ItemInterface;
use App\Pricing\ReceiptInterface;

final class Receipt implements ReceiptInterface
{
    private array $items;

    public function __construct(private MoneyInterface $grandTotal, ItemInterface ...$items)
    {
        if (empty($items)) {
            throw new EmptyItemsException();
        }

        $this->items = $items;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function getGrandTotal(): MoneyInterface
    {
        return $this->grandTotal;
    }
}
