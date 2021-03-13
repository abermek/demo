<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\HttpKernel\Attribute\ArgumentInterface;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Input implements ArgumentInterface
{
    public function __construct(public string $formClass, public ?array $validationGroups = null)
    {
    }
}
