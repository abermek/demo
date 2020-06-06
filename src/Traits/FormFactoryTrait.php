<?php

namespace App\Traits;

use Symfony\Component\Form\FormFactoryInterface;

trait FormFactoryTrait
{
    protected FormFactoryInterface $formFactory;

    /** @required */
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }
}