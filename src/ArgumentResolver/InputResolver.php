<?php

namespace App\ArgumentResolver;

use App\Attribute\Input;
use App\Exception\Attribute\Input\EmptyTypeException;
use App\Exception\Attribute\Input\InvalidIdentityException;
use App\Exception\Attribute\Input\MissingTypeException;
use App\Exception\Input\InvalidInputException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\MappingException;
use Generator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class InputResolver implements ArgumentValueResolverInterface
{
    public function __construct(private FormFactoryInterface $formFactory, private EntityManagerInterface $em)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getAttribute() instanceof Input;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        /** @var Input $attribute */
        $attribute = $argument->getAttribute();
        $type = $argument->getType();

        if (!$type) {
            throw new EmptyTypeException();
        }

        if (!class_exists($type)) {
            throw new MissingTypeException($type);
        }

        $subject = $this->resolveSubject($request, $attribute, $type);

        $this->handleRequest($request, $attribute, $subject);

        yield $subject;
    }

    private function resolveSubject(Request $request, Input $attribute, string $type): object
    {
        if (!$attribute->identity) {
            /** @psalm-suppress UndefinedClass */
            return new $type();
        }

        try {
            return $this->em->getRepository($type)->find($request->attributes->get($attribute->identity));
        } catch (MappingException $e) {
            throw new InvalidIdentityException($attribute->identity, $type, $e->getMessage());
        }
    }

    private function handleRequest(Request $request, Input $attribute, object $subject): void
    {
        $options = [];
        if ($attribute->validationGroups !== null) {
            $options = ['validation_groups' => $attribute->validationGroups];
        }

        $form = $this->formFactory->create($attribute->formClass, $subject, $options);

        $form->submit(
            $request->getMethod() === 'GET' ? $request->query->all() : $request->request->all(),
            $request->getMethod() !== "PATCH"
        );

        if (!$form->isValid()) {
            throw new InvalidInputException($form);
        }
    }
}
