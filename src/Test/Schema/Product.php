<?php

namespace App\Test\Schema;

use App\Test\Schema;

final class Product extends Schema
{
    public function __construct()
    {
        $this->schema = [
            'type' => 'object',
            'properties' => [
                'id' => new Id(),
                'name' => ['type' => 'string'],
                'price' => new Price()
            ],
            'additionalProperties' => false,
            'required' => ['id', 'name', 'price']
        ];
    }
}
