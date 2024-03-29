<?php

namespace App\Exception\Pricing\Receipt;

use Exception;

class EmptyReceiptException extends Exception
{
    public function __construct()
    {
        parent::__construct('The Receipt requires at least one Item to be created');
    }
}
