<?php

// GREP_SUMMARY: TestClasses\ScalarWithoutAttribute, scalar construction, heuristic

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_ScalarWithoutAttribute [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class that can be built from scalar via single required parameter heuristic
 */
class ScalarWithoutAttribute
{
    public function __construct(
        public string $a,
    ) {}
}
