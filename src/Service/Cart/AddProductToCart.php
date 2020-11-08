<?php

namespace App\Service\Cart;

use App\Cart\CartInterface;
use App\DTO\CartItem\CartItemCriteria;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\Repository\CartItemRepositoryInterface;

class AddProductToCart
{
    private CartItemRepositoryInterface $repository;

    public function __construct(CartItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CartInterface $cart, Product $product, int $quantity = 1)
    {
        $criteria = new CartItemCriteria();
        $criteria->cart = $cart;
        $criteria->product = $product;

        $item = $this->repository->first($criteria);

        if (!$item) {
            $item = new CartItem();
            $item->setProduct($product);
            $item->setQuantity($quantity);

            $cart->addItem($item);
        } else {
            $item->increaseQuantity($quantity);
        }
    }
}