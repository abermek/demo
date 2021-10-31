<?php

namespace App\Exception\Attribute\Input;

use Exception;

class MissingTypeException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Class $type does not exist and could not be loaded");
    }
}
