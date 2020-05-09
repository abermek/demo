<?php

namespace App\Service\ParamConverter;

use App\Exception\BadRequest\FormValidationFailedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class DTOConverter implements ParamConverterInterface
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $options    = $configuration->getOptions();
        $formClass  = $options['form'];
        $isRequired = $options['required'] ?? true;
        $class      = $configuration->getClass();

        $dto    = new $class;
        $form   = $this->formFactory->create(
            $formClass,
            $dto,
            [
                'validation_groups' => $options['validation_groups'] ?? 'Default'
            ]
        );

        $form->handleRequest($request);

        if (!$form->isSubmitted() && $isRequired) {
            $form->submit([]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            throw new FormValidationFailedException($form->getErrors(true));
        }

        $request->attributes->set($configuration->getName(), $dto);
    }

    public function supports(ParamConverter $configuration)
    {
        return isset($configuration->getOptions()['form']);
    }
}
