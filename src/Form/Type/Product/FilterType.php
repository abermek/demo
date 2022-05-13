<?php

namespace App\Form\Type\Product;

use App\DTO\Product\Filter;
use App\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('page', TextType::class, ['empty_data' => 1])
            ->add('limit', TextType::class, ['empty_data' => 20]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'method' => 'GET',
            'data_class' => Filter::class,
        ]);
    }
}
