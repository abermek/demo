<?php

namespace App\Form\Type\Product;

use App\DTO\Product\ProductCriteria;
use App\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('method', 'GET');
        $resolver->setDefaults([
            'method' => 'GET',
            'data_class' => ProductCriteria::class,
        ]);
    }
}
