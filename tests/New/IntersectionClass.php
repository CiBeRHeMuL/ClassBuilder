<?php

// GREP_SUMMARY: New\IntersectionClass, intersection, Intersection1Interface, Intersection2Interface

namespace AndrewGos\ClassBuilder\Tests\New;

// region CLASS_IntersectionClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete class implementing both Intersection1Interface and Intersection2Interface
 */
class IntersectionClass implements Intersection1Interface, Intersection2Interface
{
    public function __construct(
        private int $a,
    ) {}
}
