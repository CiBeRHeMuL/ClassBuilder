<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

#[BuildIf(new FieldIsChecker('a', 2))]
class TestInheritInterface2 implements TestInheritInterface
{
    public function __construct(
        private int $a,
        private TestInheritInterface $b,
    ) {
    }
}
