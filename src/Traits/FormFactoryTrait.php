<?php

namespace App\Traits;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait FormFactoryTrait
{
    protected FormFactoryInterface $formFactory;

    #[Required]
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }
}
