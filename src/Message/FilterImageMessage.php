<?php

namespace App\Message;

class FilterImageMessage
{
    public function __construct(private string $image, private string $filter)
    {
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getFilter(): string
    {
        return $this->filter;
    }
}
