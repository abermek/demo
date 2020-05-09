<?php

namespace App\DTO\View\Invoice;

use App\Entity\Product;
use App\Money\MoneyInterface;
use App\Pricing\Invoice\InvoiceItem;

final class ItemView
{
    public Product $product;
    public MoneyInterface $total;
    public int $quantity;

    public function __construct(InvoiceItem $invoiceItem)
    {
        $this->product = $invoiceItem->getProduct();
        $this->total = $invoiceItem->getTotal();
        $this->quantity = $invoiceItem->getQuantity();
    }
}