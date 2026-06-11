<?php

// GREP_SUMMARY: TestClasses\TestNull, nullable int, null handling

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_TestNull [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with nullable int parameter
 */
class TestNull
{
    public function __construct(
        private ?int $a,
    ) {}
}
