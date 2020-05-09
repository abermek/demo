<?php declare(strict_types=1);

namespace App\Exception\BadRequest;

use App\DTO\BadRequest\Reason\FormError;
use App\DTO\BadRequest\ReasonList;
use Exception;
use Symfony\Component\Form\FormError as BaseError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;

class FormValidationFailedException extends Exception implements BadRequestExceptionInterface
{
    private ReasonList $reasons;
    private FormErrorIterator $errors;

    public function __construct(FormErrorIterator $errors)
    {
        parent::__construct('Form Validation Failed');

        $this->errors = $errors;
    }

    public function getReasons(): ReasonList
    {
        if (!isset($this->reasons)) {
            $reasons = [];

            /** @var BaseError $error */
            foreach ($this->errors as $error) {
                $reasons[] = new FormError($error);
            }

            $this->reasons = new ReasonList(... $reasons);
        }

        return $this->reasons;
    }
}
