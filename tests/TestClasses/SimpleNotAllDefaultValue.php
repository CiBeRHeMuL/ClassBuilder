<?php

// GREP_SUMMARY: TestClasses\SimpleNotAllDefaultValue, required and optional parameters

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_SimpleNotAllDefaultValue [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class mixing required and optional parameters
 */
class SimpleNotAllDefaultValue
{
    public function __construct(
        public int $a,
        public string $b,
        public bool $c,
        public float $d,
        public array $e = [1, 2],
        public null $f = null,
    ) {}
}
