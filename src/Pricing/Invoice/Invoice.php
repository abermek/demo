<?php

namespace App\Pricing\Invoice;

use App\Entity\Security\User;
use App\Money\MoneyInterface;

class Invoice
{
    /** @var InvoiceItem []  */
    private array $items;
    private MoneyInterface $total;
    private User $customer;

    public function __construct(User $customer, MoneyInterface $total, InvoiceItem ...$items)
    {
        $this->total = $total;
        $this->customer = $customer;
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): MoneyInterface
    {
        return $this->total;
    }

    public function getCustomer(): User
    {
        return $this->customer;
    }
}