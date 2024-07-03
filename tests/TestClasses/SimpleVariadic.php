<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;

#[CanBeBuiltFromScalar]
class SimpleVariadic
{
    private array $a;

    public function __construct(
        int ...$a
    ) {
        $this->a = $a;
    }
}
