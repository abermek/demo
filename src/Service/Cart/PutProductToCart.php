<?php

namespace App\Service\Cart;

use App\DTO\CartItem\CartItemCriteria;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\Repository\CartItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PutProductToCart
{
    private CartItemRepositoryInterface $repository;
    private EntityManagerInterface $em;

    public function __construct(CartItemRepositoryInterface $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function execute(Cart $cart, Product $product, int $quantity = 1)
    {
        $criteria = new CartItemCriteria();
        $criteria->cartId = (int) $cart->getId();
        $criteria->productId = (int) $product->getId();

        $item = $this->repository->first($criteria);

        if (!$item) {
            $item = new CartItem();
            $item->setProduct($product);
            $item->setQuantity($quantity);

            $cart->addItem($item);
        } else {
            $item->increaseQuantity($quantity);
        }

        if (!$this->em->contains($cart)) {
            $this->em->persist($cart);
        }
    }
}
