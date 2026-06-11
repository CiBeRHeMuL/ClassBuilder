<?php

// GREP_SUMMARY: New\TestInheritInterface, inheritance, AvailableInheritors, interface resolution

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_TestInheritInterface [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Interface with AvailableInheritors for intersection type resolution tests
 */
#[AvailableInheritors([
    TestInheritInterface1::class,
    TestInheritInterface2::class,
])]
interface TestInheritInterface {}
