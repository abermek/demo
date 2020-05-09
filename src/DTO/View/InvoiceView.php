<?php

namespace App\DTO\View;

use App\DTO\View\Invoice\ItemView;
use App\Money\MoneyInterface;
use App\Pricing\Invoice\Invoice;

final class InvoiceView
{
    public array $items;
    public MoneyInterface $total;

    public function __construct(Invoice $invoice)
    {
        $this->total = $invoice->getTotal();

        foreach ($invoice->getItems() as $item) {
            $this->items[] = new ItemView($item);
        }
    }
}