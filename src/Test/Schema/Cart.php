<?php

namespace App\Test\Schema;

use App\Test\Schema;

class Cart extends Schema
{
    public function __construct()
    {
        $this->schema = [
            'type' => 'object',
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'items' => new Schema\Cart\Item()
                    ]
                ],
                'total' => ['type' => new Money()]
            ],
            'additionalProperties' => false,
            'required' => ['items', 'total']
        ];
    }
}
