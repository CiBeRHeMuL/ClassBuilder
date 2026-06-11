<?php

// GREP_SUMMARY: TestClasses\SimpleDefaultValueClass, default values, optional parameters

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_SimpleDefaultValueClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with optional parameters that have default values
 */
class SimpleDefaultValueClass
{
    public function __construct(
        public int $a = 1,
        public string $b = 'asdf',
        public bool $c = false,
        public float $d = 1.123_4,
        public array $e = [1, 23],
        public null $f = null,
    ) {}
}
