<?php

namespace App\Exception\Input;

use Exception;
use Symfony\Component\Form\FormInterface;

class InvalidInputException extends Exception
{
    public function __construct(public FormInterface $form)
    {
        parent::__construct('Input Validation Failed');
    }
}
