<?php

namespace App\DTO\Product;

use App\DTO\Filter\AbstractFilter;
use Symfony\Component\Validator\Constraints as Assert;

class Filter extends AbstractFilter
{
    #[Assert\Length(min: 3, max: 120)]
    public ?string $name = null;
    #[Assert\Length(min: 3, max: 120)]
    public ?string $slug = null;
}
