<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;

#[CanBeBuiltFromScalar]
class SimpleScalarClass
{
    public function __construct(
        public string $a,
    ) {
    }
}
