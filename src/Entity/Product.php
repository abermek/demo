<?php

namespace App\Entity;

use App\Entity\Identity\GeneratedValueTrait;
use App\Entity\Security\User;
use Money\Money;

class Product
{
    use GeneratedValueTrait;

    public ?string $name = null;
    public ?string $slug = null;
    public ?Money $price = null;
    public ?User $owner = null;
}
