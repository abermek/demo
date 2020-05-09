<?php declare(strict_types=1);

namespace App\DTO\BadRequest;

class Reason
{
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
