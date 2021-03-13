<?php

namespace App\ArgumentResolver;

use App\Attribute\Input;
use App\DTO\InputInterface;
use App\Exception\Input\InvalidInputException;
use Generator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class InputArgumentResolver implements ArgumentValueResolverInterface
{
    public function __construct(private FormFactoryInterface $formFactory)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $class = $argument->getType();
        if (is_null($class)) {
            return false;
        }

        $isInput = in_array(InputInterface::class, class_implements($class));
        if (!$isInput) {
            return false;
        }

        $attribute = $argument->getAttribute();

        return $attribute instanceof Input;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        /** @var Input $attribute */
        $attribute = $argument->getAttribute();
        $class = $argument->getType();
        $dto = new $class;

        $options = [];
        if ($attribute->validationGroups !== null) {
            $options = ['validation_groups' => $attribute->validationGroups];
        }

        $form = $this->formFactory->create($attribute->formClass, $dto, $options);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->submit([]);
        }

        if (!$form->isValid()) {
            throw new InvalidInputException($form);
//            return View::create(new InvalidFormResponse($form), Response::HTTP_BAD_REQUEST);
        }

        yield $dto;
    }
}
