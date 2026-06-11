<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceBadClass, inheritance failure, self-reference

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_SimpleInheritanceBadClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test abstract class with no AvailableInheritors (should fail)
 */
#[AvailableInheritors([SimpleInheritanceBadClass::class])]
class SimpleInheritanceBadClass
{
    public function __construct(
        string $name,
    ) {}
}
