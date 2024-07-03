<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attributes\BuildIf;
use AndrewGos\ClassBuilder\Attributes\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

#[CanBeBuiltFromScalar]
#[BuildIf(new FieldIsChecker('a', 1))]
class TestInheritInterface1 implements TestInheritInterface
{
    public function __construct(
        private int $a,
    ) {
    }
}
