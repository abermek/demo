<?php

namespace App\Form\Type\Cart;

use App\Entity\Cart\Item;
use App\Form\Type\AbstractType;
use App\Form\Type\Product\SlugType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', SlugType::class)
            ->add('quantity', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(['data_class' => Item::class]);
    }
}
