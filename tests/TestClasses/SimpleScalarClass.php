<?php

// GREP_SUMMARY: TestClasses\SimpleScalarClass, scalar construction, CanBeBuiltFromScalar

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;

// region CLASS_SimpleScalarClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class buildable from scalar value (single constructor parameter)
 */
#[CanBeBuiltFromScalar]
class SimpleScalarClass
{
    public function __construct(
        public string $a,
    ) {}
}
