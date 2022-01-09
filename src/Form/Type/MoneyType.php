<?php

namespace App\Form\Type;

use App\Form\DataTransformer\Money\MoneyToArrayTransformer;
use App\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MoneyType extends AbstractType
{
    public function __construct(private MoneyToArrayTransformer $moneyToArrayTransformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class)
            ->add('currency', TextType::class)
            ->addModelTransformer($this->moneyToArrayTransformer);
    }
}
