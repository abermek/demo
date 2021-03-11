<?php

namespace App\DTO\Response;

class BadRequestResponse
{
    public array $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }
}
