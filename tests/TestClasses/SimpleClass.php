<?php

// GREP_SUMMARY: TestClasses\SimpleClass, primitive types, basic construction

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_SimpleClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test basic class with all primitive types: int, string, bool, float, array, null
 */
class SimpleClass
{
    public function __construct(
        public int $a,
        public string $b,
        public bool $c,
        public float $d,
        public array $e,
        public null $f,
    ) {}
}
