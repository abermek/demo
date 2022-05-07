<?php

namespace App\Test\Schema;

use App\Test\Schema;

class Page extends Schema
{
    protected array $schema = [
        'type' => 'object',
        'properties' => [
            'items' => [
                'type' => 'array',
                'minItems' => 0,
            ],
            'total' => [
                'type' => 'number',
                'minimum' => 0
            ],
            'page' => [
                'type' => 'number',
                'minimum' => 1
            ]
        ],
        'additionalProperties' => false,
        'required' => ['items', 'total', 'page'],
    ];

    protected function setItemSchema(Schema $schema, int $minItems = 1): void
    {
        $this->schema['properties']['items']['items'] = $schema;
        $this->schema['properties']['minItems'] = $minItems;
    }
}
