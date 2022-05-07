<?php

namespace App\Test\Schema\Product;

use App\Test\Schema\Page;
use App\Test\Schema\Product;

final class Products extends Page
{
    public function __construct()
    {
        $this->setItemSchema(new Product());
    }
}
