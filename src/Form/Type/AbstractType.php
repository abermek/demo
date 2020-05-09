<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType as ParentType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractType extends ParentType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('csrf_protection', false);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}