<?php

namespace App\Service\Cart;

use App\DTO\Purchase;
use App\Entity\Cart;
use App\Entity\Security\User;
use App\Pricing\ReceiptInterface;
use App\Service\Pricing\PricingStrategy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ActiveCart
{
    private Cart $cart;

    public function __construct(EntityManagerInterface $em, Security $security, private PricingStrategy $pricing)
    {
        /** @var User $user */
        $user = $security->getUser();
        $cart = $user->getCart();

        if ($cart === null) {
            $this->cart = new Cart($user);
            $em->persist($this->cart);
        } else {
            $this->cart = $cart;
        }
    }

    public function addPurchase(Purchase $purchase): void
    {
        $this->cart->addProduct($purchase->product, $purchase->quantity);
    }

    public function removePurchase(Purchase $purchase): void
    {
        $this->cart->removeProduct($purchase->product, $purchase->quantity);
    }

    public function getPurchases(): iterable
    {
        return $this->cart->getItems();
    }

    public function getReceipt(): ?ReceiptInterface
    {
        return $this->cart->isEmpty()
            ? null
            : $this->pricing->execute(... $this->cart->getItems());
    }

    public function isEmpty(): bool
    {
        return $this->cart->isEmpty();
    }
}
