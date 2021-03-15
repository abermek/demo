<?php

namespace App\Form\Type;

use App\Form\DataTransformer\NumberToMoneyTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    private NumberToMoneyTransformer $transformer;

    public function __construct(NumberToMoneyTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'The price is not valid',
        ]);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
