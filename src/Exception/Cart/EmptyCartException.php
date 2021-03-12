<?php

namespace App\Exception\Cart;

use Exception;

class EmptyCartException extends Exception
{
    protected $message = 'The Cart is empty';
}
