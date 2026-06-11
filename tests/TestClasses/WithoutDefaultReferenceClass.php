<?php

// GREP_SUMMARY: TestClasses\WithoutDefaultReferenceClass, reference, no default value, by-reference

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

// region CLASS_WithoutDefaultReferenceClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with a reference-type parameter without a default value
 */
class WithoutDefaultReferenceClass
{
    public function __construct(
        public ?int &$a,
    ) {}
}
