<?php

// GREP_SUMMARY: New\Intersection2Interface, intersection, AvailableInheritors, interface

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_Intersection2Interface [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Second interface for intersection type testing
 */
#[AvailableInheritors([
    IntersectionClass::class,
])]
interface Intersection2Interface {}
