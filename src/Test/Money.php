<?php

namespace App\Test;

use JetBrains\PhpStorm\ArrayShape;

final class Money
{
    protected function __construct()
    {}

    #[ArrayShape(['amount' => "string", 'currency' => "string"])]
    public static function USD(string $amount): array
    {
        return ['amount' => $amount, 'currency' => 'USD'];
    }
}
