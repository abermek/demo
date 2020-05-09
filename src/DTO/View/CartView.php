<?php

namespace App\DTO\View;

use App\Cart\CartInterface;
use App\DTO\View\Cart\ItemView;
use Swagger\Annotations as SWG;

final class CartView
{
    /**
     * @SWG\Property(type="array", items="{'type'=}")
     */
    public array $items;

    public function __construct(CartInterface $cart)
    {
        foreach ($cart->getItems() as $item) {
            $this->items[] = new ItemView($item);
        }
    }
}