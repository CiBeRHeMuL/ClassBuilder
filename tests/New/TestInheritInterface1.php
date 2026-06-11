<?php

// GREP_SUMMARY: New\TestInheritInterface1, inheritance, BuildIf, FieldIsChecker, scalar

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

// region CLASS_TestInheritInterface1 [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose First inheritor of TestInheritInterface
 */
#[CanBeBuiltFromScalar]
#[BuildIf(new FieldIsChecker('a', 1))]
class TestInheritInterface1 implements TestInheritInterface
{
    public function __construct(
        private int $a,
    ) {}
}
