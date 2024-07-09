<?php

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;

#[Attribute]
class Field
{
    public function __construct(
        protected string $field
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }
}
