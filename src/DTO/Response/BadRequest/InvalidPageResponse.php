<?php

namespace App\DTO\Response\BadRequest;

use App\DTO\Response\BadRequestResponse;

final class InvalidPageResponse extends BadRequestResponse
{
    public function __construct(int $page)
    {
        parent::__construct([
            'description' => sprintf('Page #%s does not exists', $page)
        ]);
    }
}