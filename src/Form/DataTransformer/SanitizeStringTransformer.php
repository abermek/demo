<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SanitizeStringTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return $value;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException();
        }

        return filter_var($value, FILTER_SANITIZE_STRING);
    }
}