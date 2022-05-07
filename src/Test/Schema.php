<?php

namespace App\Test;

use ArrayAccess;
use Exception;
use JsonSerializable;

abstract class Schema implements JsonSerializable
{
    protected array $schema;

    public function nullable(): self
    {
        $type = $this->schema['type'] ?? null;
        if (empty($type)) {
            throw new Exception();
        }

        if (is_string($type)) {
            $this->schema['type'] = [$type, 'null'];
        }

        if (is_array($type) && !in_array('null', $this->schema['type'])) {
            $this->schema['type'][] = 'null';
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->schema;
    }
}
