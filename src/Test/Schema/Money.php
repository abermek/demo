<?php

namespace App\Test\Schema;

use App\Test\Schema;

final class Money extends Schema
{
    public function __construct()
    {
        $this->schema = [
            'type' => 'object',
            'properties' => [
                'amount' => ['type' => 'string'],
                'currency' => ['type' => 'string']
            ],
            'additionalProperties' => false,
            'required' => ['amount', 'currency']
        ];
    }
}
