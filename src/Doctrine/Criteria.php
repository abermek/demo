<?php

namespace App\Doctrine;

use Doctrine\Common\Collections;

abstract class Criteria extends Collections\Criteria
{
    protected array $expressions = [];

    public function __construct()
    {
        parent::__construct(!empty($this->expressions) ? Criteria::expr()->andX(...$this->expressions) : null);
    }
}
