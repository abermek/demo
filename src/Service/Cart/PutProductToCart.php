<?php

namespace App\Service\Cart;

use App\DTO\CartItem\CartItemCriteria;
use App\DTO\Purchase;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\CartItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PutProductToCart
{
    public function __construct(private CartItemRepositoryInterface $repository, private EntityManagerInterface $em)
    {}

    public function execute(Cart $cart, Purchase $purchase)
    {
        $criteria = new CartItemCriteria();
        $criteria->cartId = (int) $cart->getId();
        $criteria->productId = (int) $purchase->product->getId();

        $item = $this->repository->findOne($criteria);

        if (!$item) {
            $item = new CartItem();
            $item->setProduct($purchase->product);
            $item->setQuantity($purchase->quantity);

            $cart->addItem($item);
        } else {
            $item->increaseQuantity($purchase->quantity);
        }

        if (!$this->em->contains($cart)) {
            $this->em->persist($cart);
        }
    }
}
