<?php

namespace App\DTO;

final class Page
{
    private iterable $items;
    private int $number;
    private int $total;

    public function __construct(iterable $items, int $number, int $total)
    {
        $this->items = $items;
        $this->number = $number;
        $this->total = $total;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}