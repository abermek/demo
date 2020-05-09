<?php declare(strict_types=1);

namespace App\DTO\BadRequest\Reason;

use App\DTO\BadRequest\Reason;
use Symfony\Component\Form\FormError as BaseError;
use Symfony\Component\Form\FormInterface;

class FormError extends Reason
{
    private string $path;

    public function __construct(BaseError $error)
    {
        $origin     = $error->getOrigin();
        $parent     = $origin->getParent();
        $this->path = $origin->getName();

        if (!empty($parent)) {
            $this->path = $this->getPropertyPath($parent, $this->path);
        }

        parent::__construct($error->getMessage());
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

    public function getPath(): string
    {
        return $this->path;
    }
}
