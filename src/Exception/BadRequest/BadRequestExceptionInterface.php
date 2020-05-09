<?php declare(strict_types=1);

namespace App\Exception\BadRequest;

use App\DTO\BadRequest\ReasonList;

interface BadRequestExceptionInterface
{
    public function getReasons(): ReasonList;
}
