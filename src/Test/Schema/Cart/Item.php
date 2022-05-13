<?php

namespace App\Test\Schema\Cart;

use App\Test\Schema;

class Item extends Schema
{
    public function __construct()
    {
        $this->schema = [
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string'],
                'quantity' => ['type' => 'number'],
                'total' => new Schema\Money(),
                'price' => new Schema\Money()
            ],
            'additionalProperties' => false,
            'required' => ['name', 'quantity', 'total', 'price']
        ];
    }
}
