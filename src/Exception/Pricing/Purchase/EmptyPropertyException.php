<?php

namespace App\Exception\Pricing\Purchase;

use Exception;

class EmptyPropertyException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct("{$name} is empty of undefined");
    }
}
