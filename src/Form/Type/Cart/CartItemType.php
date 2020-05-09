<?php

namespace App\Form\Type\Cart;

use App\Entity\Product;
use App\Form\Type\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, ['class' => Product::class])
            ->add('quantity', IntegerType::class)
        ;
    }
}
