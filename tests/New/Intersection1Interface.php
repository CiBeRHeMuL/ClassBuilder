<?php

// GREP_SUMMARY: New\Intersection1Interface, intersection, AvailableInheritors, interface

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_Intersection1Interface [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose First interface for intersection type testing
 */
#[AvailableInheritors([
    IntersectionClass::class,
])]
interface Intersection1Interface {}
