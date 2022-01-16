<?php

namespace App\Validator\Currency;

use Symfony\Component\Validator\Constraints\Choice as BaseChoice;

/** @Annotation  */
class Choice extends BaseChoice
{
    public $message = 'The Currency you selected is not valid.';
}
