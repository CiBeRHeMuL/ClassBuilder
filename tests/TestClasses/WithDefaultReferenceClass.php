<?php

// GREP_SUMMARY: TestClasses\WithDefaultReferenceClass, reference, default value, by-reference

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_WithDefaultReferenceClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with a reference-type parameter that has a default value
 */
class WithDefaultReferenceClass
{
    public function __construct(
        public ?int &$a = null,
    ) {}
}
