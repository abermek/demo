<?php

namespace App\Exception\Attribute\Input;

use Exception;

class InvalidIdentityException extends Exception
{
    public function __construct(string $identity, string $type, string $message)
    {
        parent::__construct("Identity $identity could not be resolved to instance of class $type: $message");
    }
}
