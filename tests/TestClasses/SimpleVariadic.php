<?php

// GREP_SUMMARY: TestClasses\SimpleVariadic, variadic, variadic parameter

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;

// region CLASS_SimpleVariadic [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with variadic constructor parameter
 */
#[CanBeBuiltFromScalar]
class SimpleVariadic
{
    private array $a;

    public function __construct(
        int ...$a,
    ) {
        $this->a = $a;
    }
}
