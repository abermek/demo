<?php

namespace App\DTO\Response;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

final class FormValidationFailedResponse
{
    public array $errors = [];

    public function __construct(FormInterface $form)
    {
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

            $this->errors[] = $error;
        }
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