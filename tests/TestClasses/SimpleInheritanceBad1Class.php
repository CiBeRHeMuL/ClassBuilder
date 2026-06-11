<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceBad1Class, inheritance failure, invalid inheritor

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_SimpleInheritanceBad1Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class referencing itself as inheritor (invalid self-reference)
 */
#[AvailableInheritors([SimpleScalarClass::class])]
class SimpleInheritanceBad1Class
{
    public function __construct(
        string $name,
    ) {}
}
