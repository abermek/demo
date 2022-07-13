<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Input extends AsController
{
    public function __construct(
        public string $formClass,
        public ?array $validationGroups = null,
        public ?string $identity = null
    ) {
        parent::__construct();
    }
}
