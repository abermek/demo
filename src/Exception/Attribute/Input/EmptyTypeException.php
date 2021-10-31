<?php

namespace App\Exception\Attribute\Input;

use Exception;

class EmptyTypeException extends Exception
{
    public function __construct()
    {
        parent::__construct("Input Argument requires a type declaration of the argument it applied to");
    }
}
