<?php declare(strict_types=1);

namespace App\DTO\BadRequest;

class ReasonList
{
    /** @var Reason[]  */
    private array $reasons;

    public function __construct(Reason ...$reasons)
    {
        $this->reasons = $reasons;
    }

    public function getReasons(): array
    {
        return $this->reasons;
    }
}
