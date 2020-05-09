<?php

namespace App\Pricing\Invoice;

use App\Entity\Product;
use App\Money\MoneyInterface;

class InvoiceItem
{
    private Product $product;
    private MoneyInterface $total;
    private int $quantity;

    public function __construct(Product $product, int $quantity, MoneyInterface $total)
    {
        $this->product = $product;
        $this->total = $total;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getTotal(): MoneyInterface
    {
        return $this->total;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}