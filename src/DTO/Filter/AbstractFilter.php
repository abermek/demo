<?php

namespace App\DTO\Filter;

use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractFilter
{
    #[Assert\GreaterThanOrEqual(1)]
    public ?int $page = null;
    #[Assert\GreaterThanOrEqual(1), Assert\LessThanOrEqual(100)]
    public ?int $limit = null;
    public ?int $offset = null;
}
