<?php

// GREP_SUMMARY: TestClasses\SimpleArrayClass, ArrayType, nested array, typed array

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\ArrayType;

// region CLASS_SimpleArrayClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with simple and nested array parameters (typed via ArrayType attribute)
 */
class SimpleArrayClass
{
    public function __construct(
        #[ArrayType(['int', 'string', 'bool', 'float', 'null'])]
        public array $a,
        #[ArrayType(new ArrayType(['int', 'string', 'bool', 'float', 'null']))]
        public array $b,
        #[ArrayType('string')]
        public ?array $c,
    ) {}
}
