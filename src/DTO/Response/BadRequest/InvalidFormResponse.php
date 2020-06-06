<?php

namespace App\DTO\Response\BadRequest;

use App\DTO\Response\BadRequestResponse;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

final class InvalidFormResponse extends BadRequestResponse
{
    public function __construct(FormInterface $form)
    {
        $errors = [];

        /** @var FormError $error */
        foreach ($form->getErrors(true) as $entry) {
            $error = [
                'description' => $entry->getMessage()
            ];

            $origin = $entry->getOrigin();

            if (!is_null($origin)) {
                $parent = $origin->getParent();
                $path = $origin->getName();

                if (!empty($parent)) {
                    $path = $this->getPropertyPath($parent, $path);
                }

                $error['path'] = $path;
            }

            $errors[] = $error;
        }

        parent::__construct($errors);
    }

    private function getPropertyPath(FormInterface $form, string $baseName): string
    {
        $name   = $form->getName();
        $parent = $form->getParent();

        if (empty($name) || empty($parent)) {
            return $baseName;
        }

        return $this->getPropertyPath($parent, "{$name}.{$baseName}");
    }
}