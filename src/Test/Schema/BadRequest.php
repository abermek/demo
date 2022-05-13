<?php

namespace App\Test\Schema;

use App\Test\Schema;

class BadRequest extends Schema
{
    public function __construct()
    {
        $this->schema = [
           'type' => 'object',
            'properties' => [
                'errors' => [
                    'type' => 'array',
                    'items' => [
                        'items' => [
                            'type' => 'object',
                            'properties' => [
                                'path' => ['type' => 'string'],
                                'description' => ['type' => 'string']
                            ],
                            'additionalProperties' => false,
                            'required' => ['path', 'description']
                        ]
                    ]
                ]
            ],
            'additionalProperties' => false,
            'required' => ['errors']
        ];
    }
}
