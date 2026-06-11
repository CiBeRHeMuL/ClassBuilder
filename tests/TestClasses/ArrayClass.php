<?php

// GREP_SUMMARY: TestClasses\ArrayClass, nested array, ArrayType, typed array

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\ArrayType;

// region CLASS_ArrayClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with nested array and typed array parameters (Field+ArrayType combined)
 */
class ArrayClass
{
    public function __construct(
        public string $a,
        #[ArrayType(SimpleScalarClass::class)]
        public array $b,
    ) {}
}
