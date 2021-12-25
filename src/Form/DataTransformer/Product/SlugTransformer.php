<?php

namespace App\Form\DataTransformer\Product;

use App\Entity\Product;
use App\Repository\Doctrine\ProductRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SlugTransformer implements DataTransformerInterface
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function transform($value): string
    {
        /** @var Product $value */
        if ($value === null) {
            return '';
        }

        $slug = $value->getSlug();

        return $slug ?? '';
    }

    public function reverseTransform($value): ?Product
    {
        if (empty($value)) {
            return null;
        }

        $product = $this->repository->findOneBySlug($value);

        if (!$product) {
            throw new TransformationFailedException(
                sprintf('A Product with slug "%s" does not exist!', $value)
            );
        }

        return $product;
    }
}
