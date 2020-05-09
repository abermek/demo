<?php

namespace App\Exception\BadRequest;

use App\DTO\BadRequest\ReasonList;
use App\DTO\BadRequest\Reason;
use Exception;

class PageOutOfRangeException extends Exception implements BadRequestExceptionInterface
{
    private int $page;

    public function __construct(int $page)
    {
        $this->page = $page;

        parent::__construct("Page #{$this->page} does not exists");
    }

    public function getReasons(): ReasonList
    {
        return new ReasonList(new Reason($this->getMessage()));
    }
}
